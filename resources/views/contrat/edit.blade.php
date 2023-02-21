@extends('layouts.master')
@section('title', 'Modifier contrat ' . $contrat->reference)
@section('links')
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Contrats</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $contrat->reference }}</li>
            </ol>
        </nav>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <form action="{{ route('client.update') }}" method="post">
                @csrf
                <input type="text" hidden value="{{ $contrat->id }}" name="contrat">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" @if ($contrat->possedable_type === 'App\Models\Terrain') checked @endif type="radio"
                                name="radios" id="inlineRadio1" value="1">
                            <label class="form-check-label" for="inlineRadio1">Terrain</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" @if ($contrat->possedable_type === 'App\Models\Appartement') checked @endif type="radio"
                                name="radios" id="inlineRadio2" value="2">
                            <label class="form-check-label" for="inlineRadio2">Appartement</label>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3"></div>
                    <div class="col-sm-6 mb-3">
                        <label for="client">Clients</label>
                        <select class="form-control @error('client_id') is-invalid @enderror" id="client"
                            name="client_id">
                            <option disabled selected>selection du client</option>
                            @foreach ($clients as $client)
                                <option @if (old('client_id') == $client->id) selected @endif value="{{ $client->id }}">
                                    {{ $client->nom_complet }}</option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3 @if ($contrat->possedable_type === 'App\Models\Terrain') d-none @endif" id="appartement-group">
                        <label for="appartement">Appartement</label>
                        <select class="form-control @error('possedable_id') is-invalid @enderror" id="appartement"
                            name="possedable_id">
                            <option disabled selected>selection d'appartement</option>
                            @foreach ($appartements as $appartement)
                                <option @if (old('possedable_id') == $appartement->id) selected @endif value="{{ $appartement->id }}">
                                    {{ $appartement->nom }}</option>
                            @endforeach
                        </select>
                        @error('possedable_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3 @if ($contrat->possedable_type === 'App\Models\Appartement') d-none @endif" id="terrain-group">
                        <label for="terrain">Terrain</label>
                        <select class="form-control @error('possedable_id') is-invalid @enderror" id="terrain"
                            name="possedable_id">
                            <option disabled selected>selection de terrain</option>
                            @foreach ($terrains as $terrain)
                                <option @if (old('possedable_id') == $terrain->id) selected @endif value="{{ $terrain->id }}">
                                    {{ $terrain->nom }}</option>
                            @endforeach
                        </select>
                        @error('possedable_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="debut">Debut</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <input data-datepicker="" class="form-control" id="debut" type="text" name="debut"
                                class="@error('debut') is-invalid @enderror">
                        </div>
                        @error('debut')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="fin">Fin</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <input data-datepicker="" class="form-control" id="fin" type="text" name="fin"
                                class="form-control @error('fin') is-invalid @enderror">
                        </div>
                        @error('fin')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <button class="btn btn-primary" type="submit">modifier</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        new SlimSelect({
            select: '#type'
        })
    </script>
@endsection
