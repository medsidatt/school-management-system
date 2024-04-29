@extends('layouts.app')
@section('title', 'Hello')

@section('content')

    <div class="pagetitle">
        <h1>List des parents</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Parents</li>
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
                            <div class="col"><h5 class="card-title">Tout les parents</h5></div>
{{--                            <div class="col mt-2">--}}
{{--                                <div class="d-flex justify-content-end">--}}
{{--                                    <a href="{{ route('parents.create') }}" class="btn btn-primary">Ajouter</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-responsive">
                            <thead class="table-bordered">
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>NNI</th>
                                <th>Nom</th>
                                <th>TEL</th>
                                <th data-type="date" data-format="YYYY/DD/MM">Date de naissance</th>
                                <th>Sexe</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($parents as $parent)
                                <tr>
                                    <td>{{ $parent->id }}</td>

                                    <td>
                                        <img src="{{ asset('./assets/img/profile-img.jpg') }}"
                                             width="30"
                                             class="rounded-circle image">
                                    <td>{{ $parent->nni }}</td>

                                    </td>
                                    <td>{{ $parent->first_name . ' ' . $parent->last_name }}</td>
                                    <td>{{ $parent->tel }}</td>
                                    <td>{{ $parent->date_of_birth }}</td>
                                    <td>{{ $parent->sex }}</td>
                                    <td>
                                        <a href="{{ route('parents.show', $parent->id) }}"><i class="bi bi-eye text-secondary"></i></a>
{{--                                        <a href=""><i class="bi bi-pencil-square text-primary"></i></a>--}}
{{--                                        <a href=""><i class="bi bi-trash text-danger"></i></a>--}}
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
