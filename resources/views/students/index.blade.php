@extends('layouts.app')
@section('title', 'List des etudiants')

@section('content')

    <div class="pagetitle">
        <h1>List des eleves</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Eleve</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col"><h5 class="card-title">Tout les eleves</h5></div>
                            <div class="col mt-2">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('students.create') }}" class="btn btn-primary">Ajouter</a>
                                </div>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-responsive">
                            <thead class="table-bordered">
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>RIM</th>
                                <th>Nom</th>
                                <th>Nom de parent</th>
                                <th>Sexe</th>
                                <th>Classe</th>
                                <th data-type="date" data-format="YYYY/DD/MM">Date de naissance</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>
                                        <img src="{{ asset('./assets/img/profile-img.jpg') }}"
                                             width="30"
                                             class="rounded-circle image">
                                    <td>{{ $student->rim }}</td>

                                    </td>
                                    <td>{{ $student->first_name . ' ' . $student->last_name }}</td>
                                    <td>{{ $student->p_fn . ' ' . $student->p_ln }}</td>
                                    <td>{{ $student->sex }}</td>
                                    <td>{{ $student->c_name }}</td>
                                    <td>{{ $student->date_of_birth }}</td>
                                    <td>
                                        <a href="{{ route('students.view', $student->id) }}"><i
                                                class="bi bi-eye text-secondary"></i></a>
                                        <a href="{{ route('students.edit', $student->id) }}"><i
                                                class="bi bi-pencil-square text-primary"></i></a>
                                        <a href="#"
                                           data-bs-toggle="modal" data-bs-target="#deleteModel_{{ $student->id }}">
                                            <i class="bi bi-trash text-danger"></i></a>

                                        <div class="modal fade" id="deleteModel_{{ $student->id }}" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('students.delete', $student->id) }}" method="post">
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
                                                                - {{ $student->first_name . ' ' .  $student->last_name}}
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
