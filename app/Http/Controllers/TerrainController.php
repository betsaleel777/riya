<?php

namespace App\Http\Controllers;

use App\Exports\TerrainExport;
use App\Models\Proprietaire;
use App\Models\Terrain;
use App\Models\TypeTerrain;
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
        return view(self::INDEX, compact('terrains', 'searching'));
    }

    public function create(): View
    {
        $types = TypeTerrain::get();
        $proprietaires = Proprietaire::get();
        return view('terrain.create', compact('proprietaires', 'types'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(Terrain::RULES, Terrain::MESSAGES);
        $terrain = new Terrain($request->all());
        $terrain->codeGenerate();
        $terrain->attestation_villageoise = $request->has('attestation_villageoise');
        $terrain->titre_foncier = $request->has('titre_foncier');
        $terrain->document_cession = $request->has('document_cession');
        $terrain->arreter_approbation = $request->has('arreter_approbation');
        $terrain->save();
        session()->flash('success', "Le terrain: <b>$terrain->nom</b> a été crée avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function edit(int $id): View
    {
        $terrain = Terrain::findOrFail($id);
        $types = TypeTerrain::get();
        $proprietaires = Proprietaire::get();
        return view('terrain.edit', compact('proprietaires', 'terrain', 'types'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(Terrain::RULES, Terrain::MESSAGES);
        $terrain = Terrain::findOrFail($request->terrain);
        $terrain->nom = $request->nom;
        $terrain->superficie = $request->superficie;
        $terrain->montant_location = $request->montant_location;
        $terrain->montant_investit = $request->montant_investit;
        $terrain->pays = $request->pays;
        $terrain->ville = $request->ville;
        $terrain->quartier = $request->quartier;
        $terrain->cout_achat = $request->cout_achat;
        $terrain->proprietaire_id = $request->proprietaire_id;
        $terrain->type_terrain_id = $request->type_terrain_id;
        $terrain->titre_foncier = $request->has('titre_foncier');
        $terrain->attestation_villageoise = $request->has('attestation_villageoise');
        $terrain->document_cession = $request->has('document_cession');
        $terrain->arreter_approbation = $request->has('arreter_approbation');
        $terrain->save();
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
        return view(self::INDEX, compact('terrains', 'searching'));
    }

    public function export()
    {
        return Excel::download(new TerrainExport, 'terrains.xlsx');
    }
}
