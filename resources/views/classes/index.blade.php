@extends('layouts.app')
@section('title', 'Hello')

@section('content')

    <div class="pagetitle">
        <h1>List des classes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Classes</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    @if(Session::has('success'))
        <div class="alert align-center alert-success alert-dismissible fade show" role="alert">
            <strong>La classe est cree</strong> <span>{{ Session::get('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        {{ Session::pull('success') }}
    @endif
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col"><h5 class="card-title">Tout les classes</h5></div>
                            <div class="col mt-2">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('classes.create') }}" class="btn btn-primary">Ajouter</a>
                                </div>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-responsive">
                            <thead class="table-bordered">
                            <tr>
                                <th>Nom</th>
                                <th>Matieres</th>
                                <th>Nombre des etudiants</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($classes as $class)
                                {{--                                @if($class->students->count() > 0)--}}
                                <tr>
                                    <td>{{ $class->name }}</td>
                                    <td>
                                        @foreach($class->subjects as $subject)
                                            <span
                                                class="border border-secondary border-radius bg-secondary-light p-1">{{ $subject->code }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span
                                            class="border border-secondary border-radius bg-secondary-light p-1">
                                            {{$class->students->count()}}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                                            <button type="button" class="btn btn-outline-primary">
                                                <a href="{{ route('classes.show', $class->id) }}"><i
                                                        class="bi bi-eye text-secondary"></i></a>
                                            </button>
                                            <button type="button" class="btn btn-outline-primary">
                                                <a href="{{ route('classes.edit', $class->id) }}"><i
                                                        class="bi bi-pencil-square text-primary"></i></a>
                                            </button>
                                            <button type="button" class="btn btn-outline-primary">
                                                <a href="#"
                                                   data-bs-toggle="modal"
                                                   data-bs-target="#deleteModel_{{ $class->id }}">
                                                    <i class="bi bi-trash text-danger"></i></a>
                                            </button>
                                        </div>

                                        <div class="modal fade" id="deleteModel_{{ $class->id }}" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('classes.delete', $class->id) }}"
                                                          method="post">
                                                        @method('delete')
                                                        @csrf

                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Suprimer
                                                                une classe</h1>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <h5 class="text-center"> Voulez vous suprimer cette
                                                                classe
                                                                - {{ $class->name }} ?
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
                                {{--                                @endif--}}
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



