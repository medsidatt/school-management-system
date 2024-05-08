@extends('layouts.app')
@section('title', 'Les professeurs de l\'etablissement')

@section('content')

    @if(Session::has('success'))
        <x-alert type="success">
            {{ Session::get('success') }}!
        </x-alert>
    @elseif(Session::has('fail'))
        <x-alert type="danger">
            {{ Session::get('fail') }}!
        </x-alert>
    @endif

    <div class="pagetitle">
        <h1>List des professeurs</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Professeurs</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col"><h5 class="card-title">Tout les professeurs</h5></div>
                            <div class="col mt-2">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('teachers.create') }}" class="btn btn-primary">Ajouter</a>
                                </div>
                            </div>
                        </div>
                        {{ request()->path() }}

                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-responsive">
                            <thead class="table-bordered">
                            <tr>

                                <th>Photo</th>
                                <th>Nom</th>
                                <th>NNI</th>
                                <th>Sexe</th>
                                <th data-type="date" data-format="YYYY/DD/MM">Date de naissance</th>
                                <th>Classes</th>
                                <th>Matieres</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td>
                                        <img src="{{ asset('./assets/img/profile-img.jpg') }}"
                                             width="30"
                                             class="rounded-circle image">

                                    </td>
                                    <td>{{ $teacher->first_name . ' ' . $teacher->last_name }}</td>
                                    <td>{{ $teacher->nni }}</td>
                                    <td>{{ $teacher->sex }}</td>
                                    <td>{{ $teacher->date_of_birth }}</td>
                                    <td>
{{--                                        <span--}}
{{--                                            class="border border-secondary border-radius bg-secondary-light p-1">1 AS</span>--}}
{{--                                        <span--}}
{{--                                            class="border border-secondary border-radius bg-secondary-light p-1">3 AS</span>--}}
                                    </td>
                                    <td>
                                        <span
                                            class="border border-secondary border-radius bg-secondary-light p-1">AR</span>
                                        <span
                                            class="border border-secondary border-radius bg-secondary-light p-1">IR</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                                            <button type="button" class="btn btn-outline-primary">
                                                <a href="{{ route('teachers.show', $teacher->id) }}"><i
                                                        class="bi bi-eye text-secondary"></i></a>
                                            </button>
                                            <button type="button" class="btn btn-outline-primary">
                                                <a href="{{ route('teachers.edit', $teacher->id) }}"><i
                                                        class="bi bi-pencil-square text-primary"></i></a>
                                            </button>
                                            <button type="button" class="btn btn-outline-primary">
                                                <a href="#"
                                                   data-bs-toggle="modal" data-bs-target="#deleteModel_{{ $teacher->id }}">
                                                    <i class="bi bi-trash text-danger"></i></a>
                                            </button>
                                        </div>
                                        <div class="modal fade" id="deleteModel_{{ $teacher->id }}" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('teachers.delete', $teacher->id) }}" method="post">
                                                        @method('delete')
                                                        @csrf

                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Suprimer
                                                                un
                                                                etudiant</h1>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <h5 class="text-center"> Voulez vous suprimer cette
                                                                etudiant
                                                                - {{ $teacher->first_name . ' ' .  $teacher->last_name}}
                                                                ?
                                                            </h5>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Returner
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Suprimer
                                                            </button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
