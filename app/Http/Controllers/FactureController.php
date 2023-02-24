<?php

namespace App\Http\Controllers;

use App\Exports\FactureExport;
use App\Models\Achat;
use App\Models\Appartement;
use App\Models\Caution;
use App\Models\Contrat;
use App\Models\Facture;
use App\Models\Loyer;
use App\Models\Terrain;
use App\Models\Visite;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FactureController extends Controller
{
    const VALIDATIONS_TYPE = [
        'loyer' => ['rules' => Loyer::RULES, 'messages' => Loyer::MESSAGES],
        'achat' => ['rules' => Achat::RULES, 'messages' => Achat::MESSAGES],
        'visite' => ['rules' => Visite::RULES, 'messages' => Visite::MESSAGES],
        'caution' => ['rules' => Caution::RULES, 'messages' => Caution::MESSAGES],
    ];

    private static function typeCreator(Request $request): int
    {
        $typable = match ($request->type) {
            'loyer' => new Loyer($request->all()),
            'achat' => new Achat($request->all()),
            'achat' => new Visite($request->all()),
        };
        $typable->save();
        return $typable->id;
    }

    private static function typeSelector(string $type, int $id): Loyer|Achat|Visite
    {
        return match ($type) {
            'loyer' => Loyer::findOrFail($id),
            'achat' => Achat::findOrFail($id),
            'achat' => Visite::findOrFail($id),
        };
    }

    public function index(): View
    {
        $factures = Facture::paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view('facture.index', compact('factures', 'searching'));
    }

    public function create(): View
    {
        $appartements = Appartement::get();
        $terrains = Terrain::get();
        $contrats = Contrat::get();
        return view('facture.create', compact('contrats', 'appartements', 'terrains'));
    }

    public function store(Request $request): RedirectResponse
    {
        [$rules, $messages] = self::VALIDATIONS_TYPE[$request->type];
        $request->validate($rules, $messages);
        $facture = new Facture($request->only('echelonner'));
        $facture->codeGenerate($request->type);
        $typable = self::typeSelector($request->type, self::typeCreator($request));
        $facture->typable()->associate($typable);
        $facture->save();
        session()->flash('success', "La facture: <b>$facture->reference</b> a été crée avec succès.");
        return redirect()->route('facture.index');
    }

    public function edit(int $id): View
    {
        $appartements = Appartement::get();
        $terrains = Terrain::get();
        $contrats = Contrat::get();
        $facture = Facture::findOrFail($id);
        return view('facture.edit', compact('contrats', 'appartements', 'terrains', 'facture'));
    }

    public function update(Request $request): RedirectResponse
    {
        [$rules, $messages] = self::VALIDATIONS_TYPE[$request->type];
        $request->validate($rules, $messages);
        $typable = self::typeSelector($request->type, $request->typable_id);
        $typable->update($request->all());
        $facture = Facture::findOrFail($request->facture);
        $facture->update($request->only('echelonner'));
        session()->flash('success', "La Facture a été modifié avec succès.");
        return redirect()->route('facture.index');
    }

    public function trash(int $id): RedirectResponse
    {
        $facture = Facture::findOrFail($id);
        $facture->delete();
        session()->flash('success', "La Facture: <b>$facture->reference</b> a été supprimé avec succès.");
        return redirect()->route('facture.index');
    }

    public function trashed(): View
    {
        $factures = Facture::onlyTrashed()->orderBy('id', 'DESC')->paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        return view('locataire.archive', compact('factures', 'searching'));
    }

    public function restore(int $id): RedirectResponse
    {
        $facture = Facture::withTrashed()->findOrFail($id);
        $facture->restore();
        session()->flash('success', "La Facture: <b>$facture->reference</b> a été restauré avec succès.");
        return redirect()->back();
    }

    public function searchTrashed(Request $request): View
    {
        $searching = false;
        if ($request->filled('search') and $request->has('archive')) {
            $found = Facture::where('reference', 'LIKE', "%$request->search%")->onlyTrashed();
            $factures = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " factures(s) archivée(s) trouvée(s)");
        } else {
            $factures = Facture::onlyTrashed()->paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('facture.archive', compact('factures', 'searching'));
    }

    public function search(Request $request): View
    {
        $searching = false;
        if ($request->filled('search')) {
            $found = Facture::where('reference', 'LIKE', "%$request->search%");
            $factures = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " factures(s) trouvée(s)");
        } else {
            $factures = Facture::paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('facture.index', compact('factures', 'searching'));
    }

    public function export()
    {
        return Excel::download(new FactureExport, 'factures.xlsx');
    }
}
