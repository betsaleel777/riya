@extends('layouts.master')
@section('title', 'Création Utilisateur')
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
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Utilisateurs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nouvel Utilisateur</li>
            </ol>
        </nav>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="{{ route('user.store') }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        <div class="text-center">
                            <img id="preview" hidden="hidden" src="{{ asset('theme/assets/img/default.jpg') }}"
                                class="rounded mx-auto d-block" height="250" width="250">
                        </div>
                        <div class="mb-4">
                            <label for="image" class="form-label">Avatar</label>
                            <input class="form-control @error('avatar') is-invalid @enderror" name="avatar" type="file"
                                id="image">
                            @error('avatar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="name">Nom</label>
                            <input value="{{ old('name') }}" type="text"
                                class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email">Email</label>
                            <input value="{{ old('email') }}" type="text"
                                class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                type="email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password">Mot de passe</label>
                            <input value="{{ old('password') }}" type="password"
                                class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation">Confirmation mot de passe</label>
                            <input value="{{ old('password_confirmation') }}" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" type="password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="admin">
                                Administrateur
                            </label>
                            <input class="form-check-input" type="checkbox" name="admin" value="true" id="admin">
                        </div>
                        <div class="align-right my-3">
                            <button class="btn btn-primary" type="submit">créer</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const input = document.getElementById('image')
        const preview = document.getElementById('preview')
        input.addEventListener('change', () => {
            const [file] = input.files
            if (file) {
                preview.src = URL.createObjectURL(file)
                preview.hidden = false
            }
        })
    </script>
@endsection
