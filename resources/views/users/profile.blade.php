@extends('layouts.master')
@section('title', 'Profile ' . $user->name)
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
                <li class="breadcrumb-item active" aria-current="page">Profile {{ $user->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-5">Information Générales</h2>
                <form action="{{ route('user.patch', [$user]) }}" method="POST">
                    @csrf
                    <input type="text" hidden value="{{ $user->id }}" name="user">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="name">Nom complet</label>
                                <input class="form-control" id="name" type="text" name="name"
                                    value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="address">Addresse</label>
                                <input class="form-control" id="address" type="text" name="adresse"
                                    value="{{ $user->adresse }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" id="email" type="email" name="email"
                                    value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Téléphone</label>
                                <input class="form-control" id="phone" type="number" name="phone"
                                    value="{{ $user->phone }}">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-gray-800 mt-2 animate-up-2" type="submit">Enregistrer</button>
                    </div>
                </form>
            </div>
            {{-- <div class="card card-body border-0 shadow mb-4 mb-xl-0">
                <h2 class="h5 mb-4">Alerts & Notifications</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                        <div>
                            <h3 class="h6 mb-1">Company News</h3>
                            <p class="small pe-4">Get Rocket news, announcements, and product updates</p>
                        </div>
                        <div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="user-notification-1">
                                <label class="form-check-label" for="user-notification-1"></label>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                        <div>
                            <h3 class="h6 mb-1">Account Activity</h3>
                            <p class="small pe-4">Get important notifications about you or activity you've missed</p>
                        </div>
                        <div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="user-notification-2" checked>
                                <label class="form-check-label" for="user-notification-2"></label>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                        <div>
                            <h3 class="h6 mb-1">Meetups Near You</h3>
                            <p class="small pe-4">Get an email when a Dribbble Meetup is posted close to my location</p>
                        </div>
                        <div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="user-notification-3" checked>
                                <label class="form-check-label" for="user-notification-3"></label>
                            </div>
                        </div>
                    </li>
                </ul>
            </div> --}}
        </div>
        <div class="col-12 col-xl-4">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow border-0 text-center p-0">
                        <div class="profile-cover rounded-top"
                            data-background="{{ asset('theme/assets/img/profile-cover.jpg') }}"></div>
                        <div class="card-body pb-5">
                            @empty($user->avatar)
                                <img class="avatar-xl rounded-circle mx-auto mt-n7 mb-4" alt="Image utilisateur"
                                    src="{{ asset('theme/assets/img/default.jpg') }}">
                            @else
                                <img class="avatar-xl rounded-circle mx-auto mt-n7 mb-4" alt="Image utilisateur"
                                    src="{{ asset('storage/' . $user->avatar) }}">
                            @endempty
                            <h4 class="h3">{{ $user->name }}</h4>
                            <h5 class="fw-normal">
                                @if ($user->admin)
                                    Administrateur
                                @else
                                    Gérant
                                @endif
                            </h5>
                            {{-- <p class="text-gray mb-4">New York, USA</p> --}}
                            {{-- <a class="btn btn-sm btn-gray-800 d-inline-flex align-items-center me-2" href="#">
                                <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z">
                                    </path>
                                </svg>
                                Connect
                            </a>
                            <a class="btn btn-sm btn-secondary" href="#">Send Message</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-body border-0 shadow mb-4">
                        <h2 class="h5 mb-4">Nouvelle Photo Profile</h2>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <!-- Avatar -->
                                <img class="rounded avatar-xl" id="preview"
                                    src="{{ asset('theme/assets/img/default.jpg') }}" alt="change avatar">
                            </div>
                            <div class="file-field">
                                <div class="d-flex justify-content-xl-center ms-xl-3">
                                    <div class="d-flex">
                                        <svg class="icon text-gray-500 me-2" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <input type="file" id="image">
                                        <div class="d-md-block text-left">
                                            <div class="fw-normal text-dark mb-1">Choisir Nouvelle Une Image</div>
                                            <div class="text-gray small">JPG, JPEG, SVG or PNG. Taille maximum 2M</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            }
        })
    </script>
@endsection
