<?php

namespace App\Http\Controllers\Categories;

use App\Exports\TypeAppartementExport;
use App\Http\Controllers\Controller;
use App\Models\TypeAppartement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CategorieAppartementController extends Controller
{
    const INDEX = 'appartement.type.index';

    public function index(): View
    {
        $types = TypeAppartement::paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view('categories.appartement.index', compact('types', 'searching'));
    }

    public function create(): View
    {
        return view('categories.appartement.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(TypeAppartement::RULES, TypeAppartement::MESSAGES);
        $type = new TypeAppartement($request->all());
        $type->save();
        session()->flash('success', "Type d'appartement: $type->nom a été crée avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function edit(int $id): View
    {
        $type = TypeAppartement::findOrFail($id);
        return view('categories.appartement.edit', compact('type'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(TypeAppartement::editRules($request->type), TypeAppartement::MESSAGES);
        $type = TypeAppartement::findOrFail($request->type);
        $type->update($request->all());
        session()->flash('success', "Le type d'appartement a été modifié avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function trash(int $id): RedirectResponse
    {
        $type = TypeAppartement::findOrFail($id);
        $type->delete();
        session()->flash('success', "Le type d'appartement: '$type->nom' a été supprimé avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function trashed(): View
    {
        $types = TypeAppartement::onlyTrashed()->orderBy('id', 'DESC')->paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view('categories.appartement.archive', compact('types', 'searching'));
    }

    public function restore(int $id): RedirectResponse
    {
        $type = TypeAppartement::withTrashed()->findOrFail($id);
        $type->restore();
        session()->flash('success', "Le type d'appartement: '$type->nom' a été restauré avec succès.");
        return redirect()->back();
    }

    public function destroy(int $id): JsonResponse
    {
        $type = TypeAppartement::withTrashed()->findOrFail($id);
        $type->forceDelete();
        session()->flash('success', "Le type d'appartement: '$type->nom' a été définitivement supprimé avec succès.");
        return response()->json(['message' => "Le type d'appartement: <b>$type->nom</b> a été définitivement supprimé avec succès."]);
    }

    public function searchTrashed(Request $request): View
    {
        $searching = false;
        if ($request->filled('search') and $request->has('archive')) {
            $found = TypeAppartement::where('nom', 'LIKE', "%$request->search%")->onlyTrashed();
            $types = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " type(s) de appartement(s) archivé(s) trouvé(s)");
        } else {
            $types = TypeAppartement::onlyTrashed()->paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('categories.appartement.archive', compact('types', 'searching'));
    }

    public function search(Request $request): View
    {
        $searching = false;
        if ($request->filled('search')) {
            $found = TypeAppartement::where('nom', 'LIKE', "%$request->search%");
            $types = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " type(s) de appartement(s) trouvé(s)");
        } else {
            $types = TypeAppartement::paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('categories.appartement.index', compact('types', 'searching'));
    }

    public function export()
    {
        return Excel::download(new TypeAppartementExport, 'typeAppartement.xlsx');
    }
}
