<?php

namespace App\Http\Controllers;

use App\Exports\TerrainExport;
use App\Models\Terrain;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TerrainController extends Controller
{
    const INDEX = 'terrain.index';

    public function index(): View
    {
        $terrains = Terrain::paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view('terrain.index', compact('terrains', 'searching'));
    }

    public function create(): View
    {
        return view('terrain.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(Terrain::RULES, Terrain::MESSAGES);
        $terrain = new Terrain($request->all());
        $terrain->save();
        session()->flash('success', "Le terrain: <b>$terrain->nom</b> a été crée avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function edit(int $id): View
    {
        $terrain = Terrain::findOrFail($id);
        return view('terrain.edit', compact('terrain'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(Terrain::editRules($request->type), Terrain::MESSAGES);
        $terrain = Terrain::findOrFail($request->type);
        $terrain->update($request->all());
        session()->flash('success', "Le terrain a été modifié avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function trash(int $id): RedirectResponse
    {
        $terrain = Terrain::findOrFail($id);
        $terrain->delete();
        session()->flash('success', "Le terrain: <b>$terrain->nom</b> a été supprimé avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function trashed(): View
    {
        $terrains = Terrain::onlyTrashed()->orderBy('id', 'DESC')->paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view('terrain.archive', compact('terrains', 'searching'));
    }

    public function restore(int $id): RedirectResponse
    {
        $terrain = Terrain::withTrashed()->findOrFail($id);
        $terrain->restore();
        session()->flash('success', "Le terrain: <b>$terrain->nom</b> a été restauré avec succès.");
        return redirect()->back();
    }

    public function destroy(int $id): JsonResponse
    {
        $terrain = Terrain::withTrashed()->findOrFail($id);
        $terrain->forceDelete();
        return response()->json(['message' => "Le Terrain: <b>$terrain->nom</b> a été définitivement supprimé avec succès."]);
    }

    public function searchTrashed(Request $request): View
    {
        $searching = false;
        if ($request->filled('search') and $request->has('archive')) {
            $found = Terrain::where('nom', 'LIKE', "%$request->search%")->onlyTrashed();
            $terrains = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " terrain(s) archivé(s) trouvé(s)");
        } else {
            $terrains = Terrain::onlyTrashed()->paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('terrain.archive', compact('terrains', 'searching'));
    }

    public function search(Request $request): View
    {
        $searching = false;
        if ($request->filled('search')) {
            $found = Terrain::where('nom', 'LIKE', "%$request->search%");
            $terrains = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " terrain(s) trouvé(s)");
        } else {
            $terrains = Terrain::paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('terrain.index', compact('terrains', 'searching'));
    }

    public function export()
    {
        return Excel::download(new TerrainExport, 'terrains.xlsx');
    }
}
