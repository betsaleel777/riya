@extends('layouts.master')
@section('title', 'Création de terrain')
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
                <li class="breadcrumb-item"><a href="{{ route('terrain.index') }}">Terrains</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nouveau Terrain</li>
            </ol>
        </nav>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <form action="{{ route('terrain.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="nom">Nom</label>
                        <input value="{{ old('nom') }}" type="text"
                            class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom">
                        @error('nom')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="superficie">Superficie</label>
                        <input value="{{ old('superficie') }}" type="text"
                            class="form-control @error('superficie') is-invalid @enderror" id="superficie"
                            name="superficie">
                        @error('superficie')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="montant_location">Montant de Location</label>
                        <input value="{{ old('montant_location') }}" type="text"
                            class="form-control @error('montant_location') is-invalid @enderror" id="montant_location"
                            name="montant_location">
                        @error('montant_location')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="montant_investit">Montant Investit</label>
                        <input value="{{ old('montant_investit') }}" type="text"
                            class="form-control @error('montant_investit') is-invalid @enderror" id="montant_investit"
                            name="montant_investit">
                        @error('montant_investit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="pays">Pays</label>
                        <input value="{{ old('pays') }}" type="text"
                            class="form-control @error('pays') is-invalid @enderror" id="pays" name="pays">
                        @error('pays')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="ville">Ville</label>
                        <input value="{{ old('ville') }}" type="text"
                            class="form-control @error('ville') is-invalid @enderror" id="ville" name="ville">
                        @error('ville')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="quartier">Quartier</label>
                        <input value="{{ old('quartier') }}" type="text"
                            class="form-control @error('quartier') is-invalid @enderror" id="quartier" name="quartier">
                        @error('quartier')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="cout_achat">Coût d'achat</label>
                        <input value="{{ old('cout_achat') }}" type="text"
                            class="form-control @error('cout_achat') is-invalid @enderror" id="cout_achat"
                            name="cout_achat">
                        @error('cout_achat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="row container">
                            <div class="form-check col">
                                <label class="form-check-label" for="attestation_villageoise">
                                    Attestation Villageoise
                                </label>
                                <input class="form-check-input" type="checkbox" name="attestation_villageoise"
                                    value="true" id="attestation_villageoise">
                            </div>
                            <div class="form-check col">
                                <label class="form-check-label" for="titre_foncier">
                                    Titre foncier
                                </label>
                                <input class="form-check-input" type="checkbox" name="titre_foncier" value="true"
                                    id="titre_foncier">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="row container">
                            <div class="form-check col">
                                <label class="form-check-label" for="document_cession">
                                    Document cession
                                </label>
                                <input class="form-check-input" type="checkbox" name="document_cession" value="true"
                                    id="document_cession">
                            </div>
                            <div class="form-check col">
                                <label class="form-check-label" for="arreter_approbation">
                                    Arrêter d'approbation
                                </label>
                                <input class="form-check-input" type="checkbox" name="arreter_approbation"
                                    value="true" id="arreter_approbation">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="type">Types de terrains</label>
                        <select class="form-control @error('type_terrain_id') is-invalid @enderror" id="type"
                            name="type_terrain_id">
                            <option disabled selected>selection du type de terrain</option>
                            @foreach ($types as $type)
                                <option @if (old('type_terrain_id') == $type->id) selected @endif value="{{ $type->id }}">
                                    {{ $type->nom }}</option>
                            @endforeach
                        </select>
                        @error('type_terrain_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="proprietaire_id">Propriétaire</label>
                        <select class="form-control @error('proprietaire_id') is-invalid @enderror" id="proprietaire_id"
                            name="proprietaire_id">
                            <option disabled selected>selection du propriétaire</option>
                            @foreach ($proprietaires as $proprietaire)
                                <option @if (old('proprietaire_id') == $proprietaire->id) selected @endif
                                    value="{{ $proprietaire->id }}">
                                    {{ $proprietaire->nom_complet }}</option>
                            @endforeach
                        </select>
                        @error('proprietaire_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <button class="btn btn-primary" type="submit">créer</button>
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
        new SlimSelect({
            select: '#proprietaire_id'
        })
    </script>
@endsection
