<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\TypeTerrain;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class CategorieTerrainController extends Controller
{
    const INDEX = 'terrain.type.index';

    public function index(): View
    {
        $types = TypeTerrain::paginate(8);
        $searching = false;
        return view('categories.terrain.index', compact('types', 'searching'));
    }

    public function create(): View
    {
        return view('categories.terrain.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(TypeTerrain::RULES, TypeTerrain::MESSAGES);
        $type = new TypeTerrain($request->all());
        $type->save();
        session()->flash('success', "Type de terrain: $type->nom a été crée avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function edit(int $id): View
    {
        $type = TypeTerrain::findOrFail($id);
        return view('categories.terrain.edit', compact('type'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(TypeTerrain::editRules($request->type), TypeTerrain::MESSAGES);
        $type = TypeTerrain::findOrFail($request->type);
        $type->update($request->all());
        session()->flash('success', "Le type a été modifié avec succès. ");
        return redirect()->route(self::INDEX);
    }

    public function trash(int $id): RedirectResponse
    {
        $type = TypeTerrain::findOrFail($id);
        $type->delete();
        session()->flash('success', "Le type: '$type->nom' a été supprimé avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function trashed(): View
    {
        $types = TypeTerrain::onlyTrashed()->orderBy('id', 'DESC')->paginate(8);
        $searching = false;
        return view('categories.terrain.archive', compact('types', 'searching'));
    }

    public function restore(int $id): RedirectResponse
    {
        $type = TypeTerrain::withTrashed()->findOrFail($id);
        $type->restore();
        session()->flash('success', "Le type: '$type->nom' a été restauré avec succès.");
        return redirect()->back();
    }

    public function delete(int $id)
    {
        $type = TypeTerrain::withTrashed()->findOrFail($id);
        $type->forceDelete();
        session()->flash('success', "Le type: '$type->nom' a été définitivement supprimé avec succès.");
        return redirect()->back();
    }

    public function searchTrashed(Request $request): View
    {
        $searching = false;
        if ($request->filled('search') and $request->has('archive')) {
            $found = TypeTerrain::where('nom', 'LIKE', "%$request->search%")->onlyTrashed();
            $types = $found->paginate(8);
            $searching = true;
            session()->flash('info', count($found->get()) . " type(s) de terrain(s) archivé(s) trouvé(s)");
        } else {
            $types = TypeTerrain::onlyTrashed()->paginate(8);
        }
        return view('categories.terrain.archive', compact('types', 'searching'));
    }

    public function search(Request $request): View
    {
        $searching = false;
        if ($request->filled('search')) {
            $found = TypeTerrain::where('nom', 'LIKE', "%$request->search%");
            $types = $found->paginate(8);
            $searching = true;
            session()->flash('info', count($found->get()) . " type(s) de terrain(s) trouvé(s)");
        } else {
            $types = TypeTerrain::paginate(8);
        }
        return view('categories.terrain.index', compact('types', 'searching'));
    }
}
