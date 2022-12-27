@extends('layouts.master')
@section('title', 'modifier type:' . $type->nom)
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
                <li class="breadcrumb-item"><a href="{{ route('appartement.type.index') }}">Types de appartements</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $type->nom }}</li>
            </ol>
        </nav>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <form action="{{ route('appartement.type.update') }}" method="post">
                        @csrf
                        <input hidden type="text" name="type" value="{{ $type->id }}">
                        <div class="mb-4">
                            <label for="nom">Nom</label>
                            <input value="{{ $type->nom }}" type="text"
                                class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom">
                            @error('nom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="align-right">
                            <button class="btn btn-primary" type="submit">modifier</button>
                        </div>
                    </form>
                </div>
                <div class="col-6"></div>
            </div>
        </div>
    </div>
@endsection
