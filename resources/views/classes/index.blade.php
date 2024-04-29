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
                                <tr>
                                    <td>{{ $class['name'] }}</td>
                                    <td>
                                        @foreach($class['subjects'] as $subject)
                                            @if(!$loop->last)
                                                <span
                                                    class="border border-secondary border-radius bg-secondary-light p-1">{{ $subject }}</span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <!-- You can adjust this part based on your actual data -->
                                        <span
                                            class="border border-secondary border-radius bg-secondary-light p-1">50</span>
                                    </td>
                                    <td>
                                        <a href=""><i class="bi bi-eye text-secondary"></i></a>
                                        <a href="{{ route('classes.edit', $class['id']) }}"><i class="bi bi-pencil-square text-primary"></i></a>
                                        <a href=""><i class="bi bi-trash text-danger"></i></a>
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
