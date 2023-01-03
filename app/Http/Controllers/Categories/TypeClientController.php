<?php

namespace App\Http\Controllers\Categories;

use App\Exports\TypeClientsExport;
use App\Http\Controllers\Controller;
use App\Models\TypeClient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TypeClientController extends Controller
{
    const INDEX = 'client.type.index';

    public function index(): View
    {
        $types = TypeClient::paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view('categories.locataire.index', compact('types', 'searching'));
    }

    public function create(): View
    {
        return view('categories.locataire.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(TypeClient::RULES, TypeClient::MESSAGES);
        $type = new TypeClient($request->all());
        $type->save();
        session()->flash('success', "Type de client: <b>$type->nom</b> a été crée avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function edit(int $id): View
    {
        $type = TypeClient::findOrFail($id);
        return view('categories.locataire.edit', compact('type'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(TypeClient::editRules($request->type), TypeClient::MESSAGES);
        $type = TypeClient::findOrFail($request->type);
        $type->update($request->all());
        session()->flash('success', "Le type a été modifié avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function trash(int $id): RedirectResponse
    {
        $type = TypeClient::findOrFail($id);
        $type->delete();
        session()->flash('success', "Le type: <b>$type->nom</b> a été supprimé avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function trashed(): View
    {
        $types = TypeClient::onlyTrashed()->orderBy('id', 'DESC')->paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view('categories.locataire.archive', compact('types', 'searching'));
    }

    public function restore(int $id): RedirectResponse
    {
        $type = TypeClient::withTrashed()->findOrFail($id);
        $type->restore();
        session()->flash('success', "Le type: <b>$type->nom</b> a été restauré avec succès.");
        return redirect()->back();
    }

    public function destroy(int $id): JsonResponse
    {
        $type = TypeClient::withTrashed()->findOrFail($id);
        $type->forceDelete();
        return response()->json(['message' => "Le type de client: <b>$type->nom</b> a été définitivement supprimé avec succès."]);
    }

    public function searchTrashed(Request $request): View
    {
        $searching = false;
        if ($request->filled('search') and $request->has('archive')) {
            $found = TypeClient::where('nom', 'LIKE', "%$request->search%")->onlyTrashed();
            $types = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " type(s) de client(s) archivé(s) trouvé(s)");
        } else {
            $types = TypeClient::onlyTrashed()->paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('categories.locataire.archive', compact('types', 'searching'));
    }

    public function search(Request $request): View
    {
        $searching = false;
        if ($request->filled('search')) {
            $found = TypeClient::where('nom', 'LIKE', "%$request->search%");
            $types = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " type(s) de client(s) trouvé(s)");
        } else {
            $types = TypeClient::paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('categories.locataire.index', compact('types', 'searching'));
    }

    public function export()
    {
        return Excel::download(new TypeClientsExport, 'typeClient.xlsx');
    }
}
