@extends('layouts.app')
@section('title', 'List des etudiants')

@section('content')

    <div class="pagetitle">
        <h1>Informations d'un classe</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classes') }}">Classes</a></li>
                <li class="breadcrumb-item">classe</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="student-nav">Liste des etudiants</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Liste des matieres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Liste des professeurs</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Liste des etudiants du {{ $class->name }}</h5>

                    <table class="table table-striped" id="students" style="border: 1px black solid; margin: 3px;">
                        <thead>
                        <tr>
                            <td>N<sup>o</sup></td>
                            <td>Nom et prenom</td>
                            <td>Rim</td>
                            <td>Sexe</td>
                            <td>Actions</td>
                        </tr>
                        </thead>
                    </table>
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

            {{--$.ajax({--}}
            {{--    url: "{{ route('studentsByClass') }}",--}}
            {{--    success: function (response) {--}}
            {{--        console.log(response);--}}
            {{--    }--}}
            {{--})--}}

            $('#students').DataTable({
                language: {
                    info: 'Affichage de la page _PAGE_ sur _PAGES_',
                    infoEmpty: 'Aucun enregistrement disponible',
                    infoFiltered: '(filtré à partir de _MAX_ enregistrements totaux)',
                    lengthMenu: 'Afficher les enregistrements _MENU_ par page',
                    zeroRecords: 'Rien trouvé - désolé',
                    searchPlaceholder: 'Recherche',
                    search: 'Rechercher',
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('studentsByClass') }}",
                // success: function (response) {
                //     console.log(response)
                // },
                columns: [
                    { data: 'id' },
                    {
                        data: function (row) {
                            return {
                                display : row.first_name + ' ' + row.last_name
                            }
                        },
                        render : function (data) {
                            return data.display;
                        }
                    },
                    { data: 'rim' },
                    { data: 'sex' },
                    { data: 'date_of_birth' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]
            });
        });
    </script>

@endsection
