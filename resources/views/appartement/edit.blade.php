@extends('layouts.master')
@section('title', 'Modifier appartement' . $appartement->nom)
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
                <li class="breadcrumb-item"><a href="{{ route('appartement.index') }}">Appartements</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $appartement->nom }}</li>
            </ol>
        </nav>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <form action="{{ route('appartement.update') }}" method="post">
                @csrf
                <input type="text" hidden value="{{ $appartement->id }}" name="appartement">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="nom">Nom</label>
                        <input value="{{ $appartement->nom }}" type="text"
                            class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom">
                        @error('nom')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="superficie">Superficie</label>
                        <input value="{{ $appartement->superficie }}" type="text"
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
                        <input value="{{ $appartement->montant_location }}" type="text"
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
                        <input value="{{ $appartement->montant_investit }}" type="text"
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
                        <input value="{{ $appartement->pays }}" type="text"
                            class="form-control @error('pays') is-invalid @enderror" id="pays" name="pays">
                        @error('pays')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="ville">Ville</label>
                        <input value="{{ $appartement->ville }}" type="text"
                            class="form-control @error('ville') is-invalid @enderror" id="ville" name="ville">
                        @error('ville')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="quartier">Quartier</label>
                        <input value="{{ $appartement->quartier }}" type="text"
                            class="form-control @error('quartier') is-invalid @enderror" id="quartier" name="quartier">
                        @error('quartier')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="proprietaire">Propriétaire</label>
                        <input value="{{ $appartement->proprietaire }}" type="text"
                            class="form-control @error('proprietaire') is-invalid @enderror" id="proprietaire"
                            name="proprietaire">
                        @error('proprietaire')
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
                                @if ($appartement->attestation_villageoise)
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
                                @if ($appartement->titre_foncier)
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
                                @if ($appartement->document_cession)
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
                                @if ($appartement->arreter_approbation)
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
                        <div class="row container">
                            <div class="form-check col">
                                <label class="form-check-label" for="cour_commune">
                                    Cour commune
                                </label>
                                @if ($appartement->cours_commune)
                                    <input class="form-check-input" type="checkbox" name="cour_commune" checked="true"
                                        value="true" id="cour_commune">
                                @else
                                    <input class="form-check-input" type="checkbox" name="cour_commune"
                                        id="cour_commune">
                                @endif
                            </div>
                            <div class="form-check col">
                                <label class="form-check-label" for="placard">
                                    Placard
                                </label>
                                @if ($appartement->placard)
                                    <input class="form-check-input" type="checkbox" name="placard" checked="true"
                                        value="true" id="placard">
                                @else
                                    <input class="form-check-input" type="checkbox" name="placard" id="placard">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="row container">
                            <div class="form-check col">
                                <label class="form-check-label" for="etage">
                                    Etage
                                </label>
                                @if ($appartement->etage)
                                    <input class="form-check-input" type="checkbox" name="etage" checked="true"
                                        value="true" id="etage">
                                @else
                                    <input class="form-check-input" type="checkbox" name="etage" id="etage">
                                @endif
                            </div>
                            <div class="form-check col">
                                <label class="form-check-label" for="cuisine">
                                    Cuisine
                                </label>
                                @if ($appartement->cuisine)
                                    <input class="form-check-input" type="checkbox" name="cuisine" checked="true"
                                        value="true" id="cuisine">
                                @else
                                    <input class="form-check-input" type="checkbox" name="cuisine" id="cuisine">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="row container">
                            <div class="form-check col">
                                <label class="form-check-label" for="garage">
                                    Garage
                                </label>
                                @if ($appartement->garage)
                                    <input class="form-check-input" type="checkbox" name="garage" checked="true"
                                        value="true" id="garage">
                                @else
                                    <input class="form-check-input" type="checkbox" name="garage" id="garage">
                                @endif
                            </div>
                            <div class="form-check col">
                                <label class="form-check-label" for="parking">
                                    Parking
                                </label>
                                @if ($appartement->parking)
                                    <input class="form-check-input" type="checkbox" name="parking" checked="true"
                                        value="true" id="parking">
                                @else
                                    <input class="form-check-input" type="checkbox" name="parking" id="parking">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="row container">
                            <div class="form-check col">
                                <label class="form-check-label" for="cloture">
                                    Clôture
                                </label>
                                @if ($appartement->cloture)
                                    <input class="form-check-input" type="checkbox" name="cloture" checked="true"
                                        value="true" id="cloture">
                                @else
                                    <input class="form-check-input" type="checkbox" name="cloture" id="cloture">
                                @endif
                            </div>
                            <div class="form-check col">
                                <label class="form-check-label" for="toilette">
                                    Toilette
                                </label>
                                @if ($appartement->toilette)
                                    <input class="form-check-input" type="checkbox" name="toilette" checked="true"
                                        value="true" id="toilette">
                                @else
                                    <input class="form-check-input" type="checkbox" name="toilette" id="toilette">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="row container">
                            <div class="form-check col">
                                <label class="form-check-label" for="sodeci">
                                    Compteur SODECI
                                </label>
                                @if ($appartement->sodeci)
                                    <input class="form-check-input" type="checkbox" name="sodeci" checked="true"
                                        value="true" id="sodeci">
                                @else
                                    <input class="form-check-input" type="checkbox" name="sodeci" id="sodeci">
                                @endif
                            </div>
                            <div class="form-check col">
                                <label class="form-check-label" for="cie">
                                    Compteur CIE
                                </label>
                                @if ($appartement->cie)
                                    <input class="form-check-input" type="checkbox" name="cie" checked="true"
                                        value="true" id="cie">
                                @else
                                    <input class="form-check-input" type="checkbox" name="cie" id="cie">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="type">Types d'appartements</label>
                        <select class="form-control @error('type_appartement_id') is-invalid @enderror" id="type"
                            name="type_appartement_id">
                            @foreach ($types as $type)
                                <option @if ($appartement->type_appartement_id === $type->id) selected @endif value="{{ $type->id }}">
                                    {{ $type->nom }}</option>
                            @endforeach
                        </select>
                        @error('type_appartement_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="observation">Observations</label>
                        <textarea class="form-control" name="observation" id="observation" cols="30" rows="4">
                            {{ $appartement->observation }}
                        </textarea>
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
