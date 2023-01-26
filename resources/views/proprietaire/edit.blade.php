@extends('layouts.master')
@section('title', 'Modifier propriétaire ' . $proprietaire->nom_complet)
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
                <li class="breadcrumb-item"><a href="{{ route('proprietaire.index') }}">Propriétaire</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $proprietaire->nom_complet }}</li>
            </ol>
        </nav>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <form action="{{ route('proprietaire.update') }}" method="post">
                @csrf
                <input type="text" hidden name="proprietaire" value="{{ $proprietaire->id }}">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="nom_complet">Nom complet</label>
                        <input value="{{ $proprietaire->nom_complet }}" type="text"
                            class="form-control @error('nom_complet') is-invalid @enderror" id="nom_complet"
                            name="nom_complet">
                        @error('nom_complet')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="telephone">Téléphone</label>
                        <input value="{{ $proprietaire->telephone }}" type="text"
                            class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone">
                        @error('telephone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="cni">CNI</label>
                        <input value="{{ $proprietaire->cni }}" type="text"
                            class="form-control @error('cni') is-invalid @enderror" id="cni" name="cni">
                        @error('cni')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="email">Email</label>
                        <input value="{{ $proprietaire->email }}" type="text"
                            class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                            name="email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="commission_terrain">Commision terrain</label>
                        <input value="{{ $proprietaire->commission_terrain }}" type="text"
                            class="form-control @error('commission_terrain') is-invalid @enderror" id="commission_terrain"
                            name="commission_terrain">
                        @error('commission_terrain')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="commission_appartement">Commision appartement</label>
                        <input value="{{ $proprietaire->commission_appartement }}" type="text"
                            class="form-control @error('commission_appartement') is-invalid @enderror"
                            id="commission_appartement" name="commission_appartement">
                        @error('commission_appartement')
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
    </script>
@endsection
