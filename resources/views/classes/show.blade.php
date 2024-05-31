@extends('layouts.app')
@section('title', 'List des etudiants')

@section('content')

    <style>
         th, td {
            text-align: left;
        }
    </style>

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

                        <table class="table display" id="students" style="width: 100%">
                            <thead>
                            <tr>
                                <td>N<sup>o</sup></td>
                                <td>Nom et prenom</td>
                                <td>Rim</td>
                                <td>Sexe</td>
                                <td>Date de naissance</td>
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

                        <table class="table" id="subjects">
                            <thead>
                            <tr>
                                <td>Label</td>
                                <td>Code</td>
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

                        <table class="table table-responsive" id="teachers">
                            <thead>
                            <tr>
                                <td>Photo</td>
                                <td>Name</td>
                                <td>NNI</td>
                                <td>Date de naissance</td>
                                <td>Sexe</td>
                                <td>Actions</td>
                            </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>

        </div>

        <!-- Modal HTML -->
        <div id="myModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter une nouvelle matiere</h5>
                    </div>
                    <div class="modal-body">
                        <form id="modal-form">
                            <input id="id" type="hidden" name="id" value="">
                            <div class="form-group">
                                <label for="name">Le nom du matiere</label>
                                <input class="form-control" name="name" id="name"
                                       aria-describedby="emailHelp"
                                       placeholder="Le nom du matiere">
                                <small id="name-error" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="code">Le code du matiere</label>
                                <input name="code" class="form-control" id="code"
                                       placeholder="Le code du matiere">
                                <small id="code-error" class="text-danger"></small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="hide-modal" type="button" class="btn btn-secondary">Anulee
                        </button>
                        <button id="send-button" type="button" class="btn btn-primary">
                            Enregistrer
                        </button>
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
        let subjectTable = $('#subjects');
        let teacherTable = $('#teachers');

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

        function editSubjectFunc(id, event) {
            let clickedButton = event.target;
            let row = $(clickedButton).closest('tr');
            $('#id').val(id);
            $('#name').val(row.find('td:eq(0)').text());
            $('#code').val(row.find('td:eq(1)').text());

            console.log(row.find('td:eq(1)').text());
            $("#myModal").modal('show');
        }

        $("#show-modal").click(function () {
            $("#myModal").modal('show');
        });

        $("#hide-modal").click(function () {
            emptyFields();
            $("#myModal").modal('hide');
        });

        function emptyFields() {
            $('#name').val('');
            $('#code').val('');
            $('#name-error').text('');
            $('#code-error').text('');
            $('#id').val('');
        }

        function reloadTeacherTable() {
            return teacherTable.DataTable({
                language: {
                    info: 'Affichage de la page _PAGE_ sur _PAGES_',
                    infoEmpty: 'Aucun enregistrement disponible',
                    emptyTable: "Aucun enregistrement disponible",
                    infoFiltered: '(filtré à partir de _MAX_ enregistrements totaux)',
                    lengthMenu: 'Afficher les enregistrements _MENU_ par page',
                    zeroRecords: 'Rien trouvé - désolé',
                    searchPlaceholder: 'Recherche',
                    search: 'Rechercher',
                },
                scrollY: 400,
                pagingType: 'simple_numbers',
                ajax: "{{ route('teachers') }}",
                serverSide: true,
                columns: [
                    {
                        data: 'img_path',
                        render: function (image) {
                            const imagePath = image ? `storage/${image}` : 'storage/images/t_placeholder.jpeg';
                            return `
                                        <div class="ratio ratio-1x1 rounded-circle overflow-hidden">
                                            <img src="{{ asset('${imagePath}') }}" alt="Raeesh">
                                        </div>
                                    `;
                        }
                    },
                    {data: 'name'},
                    {data: 'nni'},
                    {
                        data: 'sex',
                        name: 'sex',
                        render: function (sex) {
                            console.log(sex)
                            return sex === 'M'? 'Homme' : 'Famme';
                        }
                    },
                    {
                        data: 'date_of_birth',
                        name: 'date_of_birth',
                        render: function (timestamp) {
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
        }
        function reloadSubjectTable() {
            return subjectTable.DataTable({
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
                    url: "{{ route('subjectsByClass') }}",
                    data: {id: {{$class->id}}}
                },
                columns: [
                    {data: 'name'},
                    {data: 'code'},
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
            if ($.fn.dataTable.isDataTable(studentsTable)) {
                studentsTable.DataTable().destroy();
            }
            reloadStudentTable().ajax.reload();
        }
        function teachersFunc(event) {
            let activeNav = $(event.target);
            makeItActive(activeNav);
            subjectsCard.hide();
            studentsCard.hide();
            teachersCard.show();
            if ($.fn.dataTable.isDataTable(teacherTable)) {
                teacherTable.DataTable().destroy();
            }
            reloadTeacherTable().ajax.reload();
        }
        function subjectsFunc(event) {
            let activeNav = $(event.target);
            makeItActive(activeNav);
            teachersCard.hide();
            studentsCard.hide();
            subjectsCard.show();
            if ($.fn.dataTable.isDataTable(subjectTable)) {
                subjectTable.DataTable().destroy();
            }
            reloadSubjectTable().ajax.reload();
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


        $("#send-button").click(function () {
            let data = new FormData($('#modal-form')[0]);
            $.ajax({
                url: "{{ route('subjects') }}",
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.errors) {
                        clearErrorMessages();
                        $.each(response.errors, function (field, errorMessage) {
                            handleErrorMessage(field, errorMessage);
                        });
                    } else if (response.update) {
                        $("#myModal").modal('hide');
                        emptyFields();
                        $('#alert').html('<div class="alert align-center alert-success alert-dismissible fade show" role="alert">' +
                            '<strong>Modification</strong> <span>vous avez modifier une matiere</span>' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>');
                        $('#subjects').DataTable().ajax.reload();
                    } else {
                        $("#myModal").modal('hide');
                        emptyFields();
                        $('#alert').html('<div class="alert align-center alert-success alert-dismissible fade show" role="alert">' +
                            '<strong>Alert</strong> <span>vous avez ajouter une nouvelle matiere</span>' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>');
                        $('#subjects').DataTable().ajax.reload();
                    }
                }
            });
        });

        let errorFeedBacks = {
            name: $('#name-error'),
            code: $('#code-error')
        };
        let errorFields = {
            name: $('#name'),
            code: $('#code')
        };

        function clearErrorMessages() {
            updateErrorMessage(errorFeedBacks.name, '');
            updateErrorMessage(errorFeedBacks.code, '');
            removeInvalidClasses();
        }

        function removeInvalidClasses() {
            errorFields.name.removeClass('is-invalid')
            errorFields.code.removeClass('is-invalid')
        }


        function handleErrorMessage(field, errorMessage) {
            switch (field) {
                case 'name':
                    updateErrorMessage(errorFeedBacks.name, errorMessage);
                    updateMessageStatus(errorFields.name);
                    break;
                case 'code':
                    updateErrorMessage(errorFeedBacks.code, errorMessage);
                    updateMessageStatus(errorFields.code);
                    break;
            }
        }

        function updateMessageStatus(feedbackElement) {
            feedbackElement.addClass('is-invalid');
        }

        function updateErrorMessage(feedbackElement, errorMessage) {
            feedbackElement.text(errorMessage);
        }
    </script>

@endsection
