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
    <div id="alert"></div>

    <section class="section">
        <div class="row">
            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a id="students-nav" class="nav-link active" href="javascript:void(0)" onclick="studentsFunc(event)">Liste des etudiants</a>
                        </li>
                        <li class="nav-item">
                            <a id="subjects-nav" class="nav-link" href="javascript:void(0)" onclick="subjectsFunc(event)">Liste des matieres</a>
                        </li>
                        <li class="nav-item">
                            <a id="teachers-nav" class="nav-link" href="javascript:void(0)" onclick="teachersFunc(event)">Liste des professeurs</a>
                        </li>
                    </ul>
                </div>
{{--                // students card--}}
                <div id="students-card" class="card-body">
                    <h5 class="card-title">Liste des etudiants du {{ $class->name }}</h5>

                    <div style="border: 1px black solid; padding: 3px;">

                        <table class="table table-striped" id="students">
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

{{--                // subjects card--}}
                <div id="subjects-card" class="card-body">
                    <h5 class="card-title">Liste des matieres du {{ $class->name }}</h5>

                    <div style="border: 1px black solid; padding: 3px;">

                        <table class="table table-striped" id="students">
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

{{--                // teachers card--}}
                <div id="teachers-card" class="card-body">
                    <h5 class="card-title">Liste des professeurs du {{ $class->name }}</h5>

                    <div style="border: 1px black solid; padding: 3px;">

                        <table class="table table-striped" id="students">
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

        </div>
    </section>



    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            studentsCard.show();
            subjectsCard.hide();
            teachersCard.hide();
            reloadStudentTable().ajax.reload();
        });
        let studentsNav = $('#students-nav');
        let subjectsNav = $('#subjects-nav');
        let teachersNav = $('#teachers-nav');
        let studentsTable = $('#students');
        let studentsCard = $('#students-card');
        let subjectsCard = $('#subjects-card');
        let teachersCard = $('#teachers-card');

        function reloadStudentTable() {
            return studentsTable.DataTable({
                language: {
                    info: 'Affichage de la page _PAGE_ sur _PAGES_',
                    infoEmpty: 'Aucun enregistrement disponible',
                    infoFiltered: '(filtré à partir de _MAX_ enregistrements totaux)',
                    lengthMenu: 'Afficher les enregistrements _MENU_ par page',
                    zeroRecords: 'Rien trouvé - désolé',
                    searchPlaceholder: 'Recherche',
                    search: 'Rechercher',
                },
                scrollY: 400,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('studentsByClass') }}",
                    data: {id: {{$class->id}}}
                },
                columns: [
                    {data: 'id'},
                    {
                        data: function (row) {
                            return {
                                display: row.first_name + ' ' + row.last_name
                            }
                        },
                        render: function (data) {
                            return data.display;
                        }
                    },
                    {data: 'rim'},
                    {data: 'sex'},
                    {data: 'date_of_birth'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]
            });
        }

        function studentsFunc(event) {
            let activeNav = $(event.target);
            makeItActive(activeNav);
            subjectsCard.hide();
            teachersCard.hide();
            studentsCard.show();
            reloadStudentTable().ajax.reload();
        }
        function teachersFunc(event) {
            let activeNav = $(event.target);
            makeItActive(activeNav);
            subjectsCard.hide();
            studentsCard.hide();
            teachersCard.show();
        }
        function subjectsFunc(event) {
            let activeNav = $(event.target);
            makeItActive(activeNav);
            teachersCard.hide();
            studentsCard.hide();
            subjectsCard.show();
        }

        function makeItActive(navActive) {
            studentsNav.removeClass('active');
            subjectsNav.removeClass('active');
            teachersNav.removeClass('active');
            navActive.addClass('active');
        }

        function deleteFunc(id) {
            $.confirm({
                title: 'Confirmer!',
                content: 'Voulez vous suprimer cette etudiant!',
                buttons: {
                    confirm: {
                        text: 'Suprimer',
                        btnClass: 'btn-success',
                        action: function () {
                            $.ajax({
                                url: "{{ route('students.delete') }}",
                                method: 'POST',
                                data: {id: id},

                                success: function (response) {
                                    if (response.notfound && response.redirect) {
                                        window.location.href = response.redirect;
                                    }
                                    $('#students').DataTable().ajax.reload();
                                    $('#alert').html('<div class="alert align-center alert-success alert-dismissible fade show" role="alert">' +
                                        '<strong>Suprimee</strong> <span>vous avez suprimee un etudiant</span>' +
                                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                        '</div>');
                                }

                            });
                        }
                    },
                    cancel: {
                        text: 'Anulee',
                        btnClass: 'btn-danger',
                        action: function () {
                            $.alert('Annulé!');
                        }
                    }
                }
            });
        }
    </script>

@endsection
