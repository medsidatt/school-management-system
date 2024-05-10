@extends('layouts.app')
@section('title', 'Liste des classes')

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
                        <table id="classes" class="table table-striped table-responsive">
                            <thead class="table-bordered">
                            <tr>
                                <th>Nom</th>
                                <th>Date de creation</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>






    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $('#classes').DataTable({
            ajax: "{{ route('classes') }}",
            serverSide: true,
            columns: [
                {data: 'name'},
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(timestamp) {
                        const tempDate = new Date(timestamp);
                        const daysOfWeek = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                        const monthsOfYear = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                        let month = monthsOfYear[tempDate.getMonth()];
                        let dayOfWeek = daysOfWeek[tempDate.getDay()];
                        let day = tempDate.getDate();
                        let year = tempDate.getFullYear();
                        let date = `${dayOfWeek} ${day < 10 ? 0 : ''}${day} ${month} ${year}`;
                        return date;
                    }

                },
                {data: 'action', orderable: false}
            ]
        });

        })
    </script>

@endsection



