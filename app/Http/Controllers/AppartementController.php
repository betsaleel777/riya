<?php

namespace App\Http\Controllers;

use App\Exports\AppartementExport;
use App\Models\Appartement;
use App\Models\TypeAppartement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AppartementController extends Controller
{
    const INDEX = 'appartement.index';

    private static function hydrateBool(Appartement $appartement, Request $request): Appartement
    {
        $appartement->attestation_villageoise = $request->has('attestation_villageoise');
        $appartement->titre_foncier = $request->has('titre_foncier');
        $appartement->document_cession = $request->has('document_cession');
        $appartement->arreter_approbation = $request->has('arreter_approbation');
        $appartement->cour_commune = $request->has('cour_commune');
        $appartement->placard = $request->has('placard');
        $appartement->etage = $request->has('etage');
        $appartement->cuisine = $request->has('cuisine');
        $appartement->garage = $request->has('garage');
        $appartement->parking = $request->has('parking');
        $appartement->cloture = $request->has('cloture');
        $appartement->toilette = $request->has('toilette');
        $appartement->cie = $request->has('cie');
        $appartement->sodeci = $request->has('sodeci');
        return $appartement;
    }

    public function index()
    {
        $appartements = Appartement::paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view(self::INDEX, compact('appartements', 'searching'));
    }

    public function create(): View
    {
        $types = TypeAppartement::get();
        return view('appartement.create', compact('types'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(Appartement::RULES, Appartement::MESSAGES);
        $appartement = new Appartement($request->all());
        $appartement->codeGenerate();
        $appartement = self::hydrateBool($appartement, $request);
        $appartement->save();
        session()->flash('success', "L'appartement: <b>$appartement->nom</b> a été crée avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function edit(int $id): View
    {
        $appartement = Appartement::findOrFail($id);
        $types = TypeAppartement::get();
        return view('appartement.edit', compact('appartement', 'types'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(Appartement::RULES, Appartement::MESSAGES);
        $appartement = Appartement::findOrFail($request->appartement);
        $appartement->nom = $request->nom;
        $appartement->superficie = $request->superficie;
        $appartement->montant_location = $request->montant_location;
        $appartement->montant_investit = $request->montant_investit;
        $appartement->pays = $request->pays;
        $appartement->ville = $request->ville;
        $appartement->quartier = $request->quartier;
        $appartement->proprietaire = $request->proprietaire;
        $appartement->type_appartement_id = $request->type_appartement_id;
        $appartement->observation = $request->observation;
        $appartement = self::hydrateBool($appartement, $request);
        $appartement->save();
        session()->flash('success', "L'appartement a été modifié avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function trash(int $id): RedirectResponse
    {
        $appartement = Appartement::findOrFail($id);
        $appartement->delete();
        session()->flash('success', "L'appartement: <b>$appartement->nom</b> a été supprimé avec succès.");
        return redirect()->route(self::INDEX);
    }

    public function trashed(): View
    {
        $appartements = Appartement::onlyTrashed()->orderBy('id', 'DESC')->paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view('appartement.archive', compact('appartements', 'searching'));
    }

    public function restore(int $id): RedirectResponse
    {
        $appartement = Appartement::withTrashed()->findOrFail($id);
        $appartement->restore();
        session()->flash('success', "L'appartement: <b>$appartement->nom</b> a été restauré avec succès.");
        return redirect()->back();
    }

    public function destroy(int $id): JsonResponse
    {
        $appartement = Appartement::withTrashed()->findOrFail($id);
        $appartement->forceDelete();
        return response()->json(['message' => "L'appartement: <b>$appartement->nom</b> a été définitivement supprimé avec succès."]);
    }

    public function searchTrashed(Request $request): View
    {
        $searching = false;
        if ($request->filled('search') and $request->has('archive')) {
            $found = Appartement::where('nom', 'LIKE', "%$request->search%")->onlyTrashed();
            $appartement = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " appartement(s) archivé(s) trouvé(s)");
        } else {
            $appartement = Appartement::onlyTrashed()->paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('appartement.archive', compact('appartements', 'searching'));
    }

    public function search(Request $request): View
    {
        $searching = false;
        if ($request->filled('search')) {
            $found = Appartement::where('nom', 'LIKE', "%$request->search%");
            $appartement = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " appartement(s) trouvé(s)");
        } else {
            $appartement = Appartement::paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view(self::INDEX, compact('appartements', 'searching'));
    }

    public function export()
    {
        return Excel::download(new AppartementExport, 'type_appartement_id.xlsx');
    }
}
