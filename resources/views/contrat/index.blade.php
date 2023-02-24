@extends('layouts.master')
@section('title', 'Contrats')
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
                <li class="breadcrumb-item active" aria-current="page">Contrats</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Contrats</h1>
            </div>
            <div>
                @if ($searching)
                    <a href="{{ route('contrat.index') }}" class="btn btn-primary d-inline-flex align-items-center">
                        <svg class="icon icon-xs me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-arrow-left">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        retour
                    </a>
                @endif
                <a href="{{ route('contrat.export') }}" class="btn btn-primary d-inline-flex align-items-center">
                    <svg class="icon icon-xs me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-file">
                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                        <polyline points="13 2 13 9 20 9"></polyline>
                    </svg>
                    Excel
                </a>
                <a href="{{ route('contrat.create') }}" class="btn btn-primary d-inline-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-plus icon icon-xs me-1">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Nouveau contrat
                </a>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="mb-3 w-25">
                <form action="{{ route('contrat.search') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <button type="submit" class="input-group-text" id="basic-addon1">
                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search">
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">#</th>
                            <th class="border-0">reference</th>
                            <th class="border-0">debut</th>
                            <th class="border-0">fin</th>
                            <th class="border-0">Bien</th>
                            <th class="border-0">Client</th>
                            <th class="border-0">Statut</th>
                            <th class="border-0 w-10">Crée le</th>
                            <th class="border-0 w-10">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $lignes = 1;
                        @endphp
                        @forelse ($contrats as $contrat)
                            <tr>
                                <td>
                                    {{ $lignes++ }}
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $contrat->reference }}</span>
                                </td>
                                <td>
                                    {{ $contrat->debut->format('d-m-Y') }}
                                </td>
                                <td>
                                    {{ $contrat->fin->format('d-m-Y') }}
                                </td>
                                <td>
                                    {{ $contrat->possedable->nom }}
                                </td>
                                <td>
                                    {{ $contrat->client->nom_complet }}
                                </td>
                                <td>
                                    @if ($contrat->isValid())
                                        <span class="fw-bold text-success">{{ $contrat->status }}</span>
                                    @elseif($contrat->isUnvalid())
                                        <span class="fw-bold text-warning">{{ $contrat->status }}</span>
                                    @else
                                        <span class="fw-bold text-danger">{{ $contrat->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $contrat->created_at->format('d-m-Y') }}
                                </td>
                                <td>
                                    <div class="row d-flex align-items-center">
                                        <div class="col-4">
                                            @if ($contrat->isUnvalid())
                                                <a href="{{ route('contrat.edit', [$contrat]) }}"
                                                    class="fa-solid fa-lg fa-edit"></a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="alert alert-light text-center" role="alert">
                                        <h6>Liste des contrats vide</h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {!! $contrats->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
