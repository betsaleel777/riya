<?php

namespace App\Http\Controllers;

use App\Exports\ProprietaireExport;
use App\Models\Proprietaire;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProprietaireController extends Controller
{
    public function index(): View
    {
        $proprietaires = Proprietaire::paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        $criteres = Proprietaire::CRITERES;
        return view('proprietaire.index', compact('proprietaires', 'searching', 'criteres'));
    }

    public function create(): View
    {
        return view('proprietaire.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(Proprietaire::RULES, Proprietaire::MESSAGES);
        $proprietaire = new Proprietaire($request->all());
        $proprietaire->save();
        session()->flash('success', "Le propriétaire: <b>$proprietaire->nom_complet</b> a été crée avec succès.");
        return redirect()->route('proprietaire.index');
    }

    public function edit(int $id): View
    {
        $proprietaire = Proprietaire::findOrFail($id);
        return view('proprietaire.edit', compact('proprietaire'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(Proprietaire::editRules($request->proprietaire), Proprietaire::MESSAGES);
        $proprietaire = Proprietaire::findOrFail($request->proprietaire);
        $proprietaire->update($request->all());
        session()->flash('success', "Le propriétaire a été modifié avec succès.");
        return redirect()->route('proprietaire.index');
    }

    public function trash(int $id): RedirectResponse
    {
        $proprietaire = Proprietaire::findOrFail($id);
        $proprietaire->delete();
        session()->flash('success', "Le propriétaire: <b>$proprietaire->nom_complet</b> a été supprimé avec succès.");
        return redirect()->route('proprietaire.index');
    }

    public function trashed(): View
    {
        $proprietaires = Proprietaire::onlyTrashed()->orderBy('id', 'DESC')->paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        $criteres = Proprietaire::CRITERES;
        return view('proprietaire.archive', compact('proprietaires', 'searching', 'criteres'));
    }

    public function restore(int $id): RedirectResponse
    {
        $proprietaire = Proprietaire::withTrashed()->findOrFail($id);
        $proprietaire->restore();
        session()->flash('success', "Le propriétaire: <b>$proprietaire->nom_complet</b> a été restauré avec succès.");
        return redirect()->back();
    }

    public function destroy(int $id): JsonResponse
    {
        $proprietaire = Proprietaire::withTrashed()->findOrFail($id);
        $proprietaire->forceDelete();
        return response()->json(['message' => "Le propriétaire: <b>$proprietaire->nom_complet</b> a été définitivement supprimé avec succès."]);
    }

    public function searchTrashed(Request $request): View
    {
        $searching = true;
        if ($request->filled('search') and $request->has('archive')) {
            $keyword = $request->string('search')->trim();
            $found = Proprietaire::onlyTrashed()->where($request->critere, 'LIKE', "%$keyword%")
                ->orWhere($request->critere, $keyword);
            $proprietaires = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            $searching = true;
            session()->flash('info', count($found->get()) . " Proprietaire(s) archivé(s) trouvé(s)");
        } else {
            $proprietaires = Proprietaire::onlyTrashed()->paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('proprietaire.archive', compact('proprietaires', 'searching'));
    }

    public function search(Request $request): View
    {
        $searching = true;
        if ($request->filled('search')) {
            $keyword = $request->string('search')->trim();
            $found = Proprietaire::where($request->critere, 'LIKE', "%$keyword%")->orWhere($request->critere, $keyword);
            $proprietaires = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            session()->flash('info', count($found->get()) . " Proprietaire(s) trouvé(s)");
        } else {
            $proprietaires = Proprietaire::paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('proprietaire.index', compact('proprietaires', 'searching'));
    }

    public function export()
    {
        return Excel::download(new ProprietaireExport, 'Client.xlsx');
    }
}
