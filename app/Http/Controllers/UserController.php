<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    const INDEX = 'user.index';
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view('users.index', compact('users', 'searching'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(User::RULES, User::MESSAGES);
        $user = new User($request->all());
        $user->admin = $request->has('admin');
        $user->password = Hash::make($request->password);
        $path = substr($request->file('avatar')->store('public/avatars'), 7);
        $user->avatar = $path;
        $user->save();
        session()->flash('success', "L'utilisateur <b>$user->name</b> a été crée avec succès.");
        return redirect()->route(self::INDEX);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $user = User::findOrFail($id);
        return view('users.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit(int $id): View
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate(User::editRules($request->user, $request->filled('oldPassword')), User::MESSAGES);
        $user = User::findOrFail($request->user);
        if ($request->hasFile('avatar')) {
            empty($user->avatar) ?: unlink(public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $user->avatar);
            $path = substr($request->file('avatar')->store('public/avatars'), 7);
            $user->avatar = $path;
        }
        if ($request->filled('oldPassword') and Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->admin = $request->has('admin');
            $user->save();
            session()->flash('success', "Utilisateur modifié avec succès.");
            return redirect()->route(self::INDEX);
        } else if (!$request->filled('oldPassword')) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->admin = $request->has('admin');
            $user->save();
            session()->flash('success', "Utilisateur modifié avec succès.");
            return redirect()->route(self::INDEX);
        } else {
            session()->flash('error', "Le mot de passe est incorrecte");
            return redirect()->back();
        }
    }

    public function trashed(): View
    {
        $users = User::onlyTrashed()->orderBy('id', 'DESC')->paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view('users.archive', compact('users', 'searching'));
    }

    public function trash(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('success', "L'utilisateur: <b>$user->name</b> a été archivé avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function restore(int $id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        session()->flash('success', "L'utilisateur: <b>$user->name</b> a été restauré avec succès.");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        empty($user->avatar) ?: unlink(public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $user->avatar);
        $user->forceDelete();
        $message = "L'utilisateur: <b>$user->name</b> a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function search(Request $request): View
    {
        $searching = false;
        if ($request->filled('search')) {
            $found = User::where('name', 'LIKE', "%$request->search%");
            $users = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " utilisateur(s) trouvé(s)");
        } else {
            $users = User::paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('users.index', compact('users', 'searching'));
    }

    public function searchTrashed(Request $request): View
    {
        $searching = false;
        if ($request->filled('search') and $request->has('archive')) {
            $found = User::where('name', 'LIKE', "%$request->search%")->onlyTrashed();
            $users = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " utilisateur(s) archivé(s) trouvé(s)");
        } else {
            $users = User::onlyTrashed()->paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('users.index', compact('users', 'searching'));
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function patch(Request $request): RedirectResponse
    {
        $request->validate(User::editRules($request->user, false));
        $user = User::findOrFail($request->user);
        $user->update($request->all());
        session()->flash('success', "Information générales modifiés avec succès.");
        return redirect()->back();
    }
}
