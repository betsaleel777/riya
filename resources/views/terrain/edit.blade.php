@extends('layouts.master')
@section('title', 'Modifier terrain' . $terrain->nom)
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
                <li class="breadcrumb-item active" aria-current="page">{{ $terrain->nom }}</li>
            </ol>
        </nav>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <form action="{{ route('terrain.update') }}" method="post">
                @csrf
                <input type="text" hidden value="{{ $terrain->id }}" name="terrain">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="nom">Nom</label>
                        <input value="{{ $terrain->nom }}" type="text"
                            class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom">
                        @error('nom')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="superficie">Superficie</label>
                        <input value="{{ $terrain->superficie }}" type="text"
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
                        <input value="{{ $terrain->montant_location }}" type="text"
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
                        <input value="{{ $terrain->montant_investit }}" type="text"
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
                        <input value="{{ $terrain->pays }}" type="text"
                            class="form-control @error('pays') is-invalid @enderror" id="pays" name="pays">
                        @error('pays')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="ville">Ville</label>
                        <input value="{{ $terrain->ville }}" type="text"
                            class="form-control @error('ville') is-invalid @enderror" id="ville" name="ville">
                        @error('ville')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="quartier">Quartier</label>
                        <input value="{{ $terrain->quartier }}" type="text"
                            class="form-control @error('quartier') is-invalid @enderror" id="quartier" name="quartier">
                        @error('quartier')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="row container">
                            <div class="form-check col">
                                <label class="form-check-label" for="attestation_villageoise">
                                    Attestation Villageoise
                                </label>
                                @if ($terrain->attestation_villageoise)
                                    <input class="form-check-input" type="checkbox" checked="true"
                                        name="attestation_villageoise" value="true" id="attestation_villageoise">
                                @else
                                    <input class="form-check-input" type="checkbox" name="attestation_villageoise"
                                        id="attestation_villageoise">
                                @endif
                            </div>
                            <div class="form-check col">
                                <label class="form-check-label" for="titre_foncier">
                                    Titre foncier
                                </label>
                                @if ($terrain->titre_foncier)
                                    <input class="form-check-input" checked="true" type="checkbox" name="titre_foncier"
                                        value="true" id="titre_foncier">
                                @else
                                    <input class="form-check-input" type="checkbox" name="titre_foncier"
                                        id="titre_foncier">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="row container">
                            <div class="form-check col">
                                <label class="form-check-label" for="document_cession">
                                    Document cession
                                </label>
                                @if ($terrain->document_cession)
                                    <input class="form-check-input" checked="true" type="checkbox"
                                        name="document_cession" value="true" id="document_cession">
                                @else
                                    <input class="form-check-input" type="checkbox" name="document_cession"
                                        id="document_cession">
                                @endif
                            </div>
                            <div class="form-check col">
                                <label class="form-check-label" for="arreter_approbation">
                                    Arrêter d'approbation
                                </label>
                                @if ($terrain->arreter_approbation)
                                    <input class="form-check-input" checked="true" type="checkbox"
                                        name="arreter_approbation" value="true" id="arreter_approbation">
                                @else
                                    <input class="form-check-input" type="checkbox" name="arreter_approbation"
                                        id="arreter_approbation">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="type">Types de terrains</label>
                        <select class="form-control @error('type_terrain_id') is-invalid @enderror" id="type"
                            name="type_terrain_id">
                            @foreach ($types as $type)
                                <option @if ($terrain->type_terrain_id === $type->id) selected @endif value="{{ $type->id }}">
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
                                <option @if ($terrain->proprietaire_id == $proprietaire->id) selected @endif
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
        new SlimSelect({
            select: '#proprietaire_id'
        })
    </script>
@endsection
