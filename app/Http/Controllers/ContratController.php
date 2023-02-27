<?php

namespace App\Http\Controllers;

use App\Exports\ContratExport;
use App\Models\Appartement;
use App\Models\Client;
use App\Models\Contrat;
use App\Models\Terrain;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ContratController extends Controller
{
    public function index(): View
    {
        $contrats = Contrat::paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        $criteres = Contrat::CRITERES;
        return view('contrat.index', compact('contrats', 'searching', 'criteres'));
    }

    public function create(): View
    {
        $clients = Client::get();
        $terrains = Terrain::get();
        $appartements = Appartement::get();
        return view('contrat.create', compact('terrains', 'appartements', 'clients'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(Contrat::RULES, Contrat::MESSAGES);
        $contrat = new Contrat($request->all());
        $request->integer('radios') === 1 ? $possedable = Terrain::findOrFail($request->possedable_id)
            : $possedable = Appartement::findOrFail($request->possedable_id);
        $contrat->possedable()->associate($possedable);
        $contrat->codeGenerate();
        $contrat->save();
        session()->flash('success', "Le contrat: <b>$contrat->reference</b> a été crée avec succès.");
        return redirect()->route('contrat.index');
    }

    public function edit(int $id): View
    {
        $clients = Client::get();
        $terrains = Terrain::get();
        $appartements = Appartement::get();
        $contrat = Contrat::findOrFail($id);
        return view('contrat.edit', compact('terrains', 'appartements', 'clients', 'contrat'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(Contrat::RULES, Contrat::MESSAGES);
        $contrat = Contrat::findOrFail($request->contrat);
        $contrat->fill($request->all());
        $request->has('terrain') ? $possedable = Terrain::findOrFail($request->possedable_id)
            : $possedable = Appartement::findOrFail($request->possedable_id);
        $contrat->possedable()->associate($possedable);
        $contrat->save();
        session()->flash('success', "Le contrat a été modifié avec succès.");
        return redirect()->route('contrat.index');
    }

    public function abort(int $id): RedirectResponse
    {
        $contrat = Contrat::findOrFail($id);
        $contrat->delete();
        session()->flash('success', "Le contrat: <b>$contrat->reference</b> a été résilié avec succès.");
        return redirect()->route('contrat.index');
    }

    public function search(Request $request): View
    {
        $searching = true;
        if ($request->filled('search')) {
            $keyword = $request->string('search')->trim();
            $found = Contrat::where($request->critere, 'LIKE', "%$keyword%")->orWhere($request->critere, $keyword);
            $contrats = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            session()->flash('info', count($found->get()) . " contrat(s) trouvé(s)");
        } else {
            $contrats = Contrat::paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('contrat.index', compact('contrats', 'searching'));
    }

    public function export()
    {
        return Excel::download(new ContratExport, 'Contrat.xlsx');
    }
}
