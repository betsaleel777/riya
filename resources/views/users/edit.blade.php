@extends('layouts.master')
@section('title', 'modifier utilisateur' . $user->name)
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
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Liste des Utilisateurs</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="{{ route('user.update') }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        <input hidden type="text" value="{{ $user->id }}" name="user">
                        <div class="text-center">
                            @empty($user->avatar)
                                <img id="preview" hidden="hidden" src="{{ asset('theme/assets/img/default.jpg') }}"
                                    class="rounded mx-auto d-block" height="250" width="250">
                            @else
                                <img id="preview" hidden="hidden" src="{{ asset('storage/' . $user->avatar) }}"
                                    class="rounded mx-auto d-block" height="250" width="250">
                            @endempty
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
                            <input value="{{ $user->name }}" type="text"
                                class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email">Email</label>
                            <input value="{{ $user->email }}" type="text"
                                class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                type="email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="oldPassword">Ancien Mot de passe</label>
                            <input type="password" class="form-control @error('oldPassword') is-invalid @enderror"
                                id="oldPassword" name="oldPassword">
                            @error('oldPassword')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password">Nouveau Mot de passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation">Confirmation mot de passe</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
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
                            @if ($user->admin)
                                <input class="form-check-input" checked="true" type="checkbox" name="admin" value="true"
                                    id="admin">
                            @else
                                <input class="form-check-input" type="checkbox" name="admin" id="admin">
                            @endif
                        </div>
                        <div class="align-right my-3">
                            <button class="btn btn-primary" type="submit">modifier</button>
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
