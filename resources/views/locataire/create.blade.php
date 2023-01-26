@extends('layouts.master')
@section('title', 'Création de client')
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
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nouveau Client</li>
            </ol>
        </nav>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <form action="{{ route('client.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="nom_complet">Nom complet</label>
                        <input value="{{ old('nom_complet') }}" type="text"
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
                        <input value="{{ old('telephone') }}" type="text"
                            class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone">
                        @error('telephone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="cni">CNI</label>
                        <input value="{{ old('cni') }}" type="text"
                            class="form-control @error('cni') is-invalid @enderror" id="cni" name="cni">
                        @error('cni')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="email">Email</label>
                        <input value="{{ old('email') }}" type="text"
                            class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                            name="email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="type">Types de clients</label>
                        <select class="form-control" id="type" name="type_client_id">
                            <option disabled selected>selection du type de client</option>
                            @foreach ($types as $type)
                                <option @if (old('type_client_id') == $type->id) selected @endif value="{{ $type->id }}">
                                    {{ $type->nom }}</option>
                            @endforeach
                        </select>
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
    </script>
@endsection
