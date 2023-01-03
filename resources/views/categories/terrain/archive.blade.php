@extends('layouts.master')
@section('title', 'Archives Types de Terrains')
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
                <li class="breadcrumb-item"><a href="{{ route('terrain.type.index') }}">Types de Terrains</a></li>
                <li class="breadcrumb-item active" aria-current="page">Types Archivés</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Types Archivés</h1>
            </div>
            <div>
                @if ($searching)
                    <a href="{{ route('terrain.type.trashed') }}" class="btn btn-primary d-inline-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-arrow-left">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        retour
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="mb-3 w-25">
                <form action="{{ route('terrain.type.searchTrashed') }}" method="POST">
                    @csrf
                    <input type="text" hidden name="archive" value="1">
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
                            <th class="border-0 w-50">Nom</th>
                            <th class="border-0 w-50">Supprimé le</th>
                            <th class="border-0 w-10">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $lignes = 1;
                        @endphp
                        @forelse ($types as $type)
                            <tr>
                                <td>
                                    {{ $lignes++ }}
                                </td>
                                <td>
                                    {{ $type->nom }}
                                </td>
                                <td>
                                    {{ $type->deleted_at }}
                                </td>
                                <td>
                                    <div class="row d-flex align-items-center">
                                        <div class="col-4">
                                            <a href="{{ route('terrain.type.restore', [$type]) }}"
                                                class="fa-solid fa-lg fa-trash-can-arrow-up"></a>
                                        </div>
                                        <div class="col-4">
                                            <div class="col-4">
                                                <button
                                                    onclick="question({{ json_encode(['name' => $type->nom, 'link' => 'destroy/' . $type->id]) }})"
                                                    class="btn btn-link btn-sm">
                                                    <i class="fa-solid fa-lg fa-trash"></i>
                                                </button>
                                                {{-- <a href="{{ route('terrain.type.delete', [$type]) }}"
                                                    class="fa-solid fa-lg fa-trash"></a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-light text-center" role="alert">
                                        <h6>Types de terrains archivés vide</h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {!! $types->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('theme/vendor/notyf/notyf.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/notification.js') }}"></script>
    <script>
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-danger mx-2',
                denyButton: 'btn btn-primary mx-2'
            },
            buttonsStyling: false,
            showDenyButton: true,
            confirmButtonText: 'valider',
            denyButtonText: `Abandonner`,
        });

        function question(payload) {
            swalWithBootstrapButtons.fire(
                'SUPPRESSION IRREVERSIBLE',
                `Voulez-vous réelement supprimer le type: <b>${payload.name}</b> ?`,
                'question'
            ).then((result) => {
                if (result.isConfirmed) {
                    fetch(payload.link, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    }).then(() => {
                        notifier('success', `<b>${payload.name}</b> a été définitivement supprimé.`)
                        setTimeout(() => {
                            location.reload();
                        }, "2500")

                    })
                }
            })
        }
    </script>
@endsection
