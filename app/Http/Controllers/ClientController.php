<?php

namespace App\Http\Controllers;

use App\Exports\ClientsExport;
use App\Models\Client;
use App\Models\TypeClient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
    const INDEX = 'locataire.index';

    public function index(): View
    {
        $clients = Client::paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        $criteres = Client::CRITERES;
        return view('locataire.index', compact('clients', 'searching', 'criteres'));
    }

    public function create(): View
    {
        $types = TypeClient::get();
        return view('locataire.create', compact('types'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(Client::RULES, Client::MESSAGES);
        $client = new Client($request->all());
        $client->save();
        session()->flash('success', "Le client: <b>$client->nom</b> a été crée avec succès.");
        return redirect()->route('client.index');
    }

    public function edit(int $id): View
    {
        $types = TypeClient::get();
        $client = Client::findOrFail($id);
        return view('locataire.edit', compact('types', 'client'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(Client::editRules($request->client), Client::MESSAGES);
        $client = Client::findOrFail($request->client);
        $client->update($request->all());
        session()->flash('success', "Le client a été modifié avec succès.");
        return redirect()->route('client.index');
    }

    public function trash(int $id): RedirectResponse
    {
        $client = Client::findOrFail($id);
        $client->delete();
        session()->flash('success', "Le client: <b>$client->nom</b> a été supprimé avec succès.");
        return redirect()->route('client.index');
    }

    public function trashed(): View
    {
        $clients = Client::onlyTrashed()->orderBy('id', 'DESC')->paginate(DEFAULT_PAGINATION_NUMBER);
        $searching = false;
        $criteres = Client::CRITERES;
        return view('locataire.archive', compact('clients', 'searching', 'criteres'));
    }

    public function restore(int $id): RedirectResponse
    {
        $client = Client::withTrashed()->findOrFail($id);
        $client->restore();
        session()->flash('success', "Le client: <b>$client->nom</b> a été restauré avec succès.");
        return redirect()->back();
    }

    public function destroy(int $id): JsonResponse
    {
        $client = Client::withTrashed()->findOrFail($id);
        $client->forceDelete();
        return response()->json(['message' => "Le client: <b>$client->nom</b> a été définitivement supprimé avec succès."]);
    }

    public function searchTrashed(Request $request): View
    {
        $searching = true;
        if ($request->filled('search') and $request->has('archive')) {
            $keyword = $request->string('search')->trim();
            $found = Client::onlyTrashed()->where($request->critere, 'LIKE', "%$keyword%")
                ->orWhere($request->critere, $keyword);
            $clients = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            session()->flash('info', count($found->get()) . " client(s) archivé(s) trouvé(s)");
        } else {
            $clients = Client::onlyTrashed()->paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('locataire.archive', compact('clients', 'searching'));
    }

    public function search(Request $request): View
    {
        $searching = true;
        if ($request->filled('search')) {
            $keyword = $request->string('search')->trim();
            $found = Client::where($request->critere, 'LIKE', "%$keyword%")->orWhere($request->critere, $keyword);
            $clients = $found->paginate(DEFAULT_PAGINATION_NUMBER);
            session()->flash('info', count($found->get()) . " client(s) trouvé(s)");
        } else {
            $clients = Client::paginate(DEFAULT_PAGINATION_NUMBER);
        }
        return view('locataire.index', compact('clients', 'searching'));
    }

    public function export()
    {
        return Excel::download(new ClientsExport, 'Client.xlsx');
    }
}
