@extends('layouts.app')
@section('title', 'Hello')

@section('content')

    <div class="pagetitle">
        <h1>List des matieres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Matiere</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        {{--                        <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p>--}}


                        <div class="row">
                            <div class="col"><h5 class="card-title">Tout les matieres</h5></div>
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
                                <th>Label</th>
                                <th>Code</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->code }}</td>
                                    <td>
                                        <a href=""><i class="bi bi-eye text-secondary"></i></a>
                                        <a href=""><i class="bi bi-pencil-square text-primary"></i></a>
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
