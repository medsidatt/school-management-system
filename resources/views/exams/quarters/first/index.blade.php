@extends('layouts.app')
@section('title', 'List des etudiants')

@section('content')

    <div class="pagetitle">
        <h1 class="mb-1">List des note d'exement du 1er trimestre</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Exements</a></li>
                <li class="breadcrumb-item">Exement 1</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <p id="cf-response-message"></p>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card w-auto">
                    <div class="card-body">
                        <div class="col"><p class="card-title">Tout les note d'exement du 1er trimestre</p></div>
                        <div class="row mb-2">
                            <form id="exam-form">
                                <input id="id" type="hidden" name="id" value="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <select id="student" name="student" class="form-select">
                                                <option value="">Etudiant ~</option>

                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <select id="subject" name="subject" class="form-select">
                                                <option value="">Matiere ~</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <input id="note" type="text" name="note" class="form-control"
                                                   placeholder="La note">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div>
                                            <button id="send-button" class="btn btn-primary" type="submit">Enregistrer
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div>
                            <select id="class" onchange="classFunc(event)" name="class_id" class="form-select">
                                <option value="">Classe ~</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <!-- Table with stripped rows -->
                        <table id="exams" class="table table-striped table-responsive">
                            <thead class="table-bordered">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Matiere</th>
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>


                        <div class="modal fade" id="exam-modal" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="javascript:void(0)" id="deleteForm" name="deleteForm"
                                          method="POST" enctype="multipart/form-data">
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
                                            <h1 id="student-message"></h1>
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


            $('#send-button').click(function (e) {
                e.preventDefault();

                let form = $('#exam-form')[0];
                let data = new FormData(form);
                let noteInput = $('#note');
                let subjectSelect = $('#subject');
                let errorFields = {
                    'student': $('#student'),
                    'note': noteInput,
                    'subject': subjectSelect
                };

                $.ajax({
                    url: "{{ route('exams.quarters.first') }}",
                    type: "POST",
                    data: data,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,

                    success: function (response) {
                        if (response.errors) {
                            $.each(response.errors, function (field, errorMessage) {
                                handleFieldError(errorFields[field], errorMessage);
                            });
                        } else {
                            // $('#exams').DataTable().draw();
                            $('#exams').DataTable().ajax.reload();
                            noteInput.val('');
                            $('#subject option:selected').next().attr('selected', 'selected');
                        }
                    }
                });
            });

            function handleFieldError(fieldElement, errorMessage) {
                fieldElement.toggleClass('is-invalid', errorMessage !== null);
                fieldElement.toggleClass('is-valid', errorMessage === null);
            }

            // End send button


        });

        function classFunc(event) {
            let classId = event.target.value;
            let subjectSelect = $('#subject');
            let studentSelect = $('#student');
            let table = $('#exams');
            $.ajax({
                url: "{{ route('exams.quarters.first.filtered', '') }}",
                data: {class_id: classId},
                method: 'GET',
                success: function (response) {
                    if ($.fn.DataTable.isDataTable('#exams')) {
                        table.DataTable().destroy();
                    }
                    studentSelect.empty();
                    subjectSelect.empty();
                    $.each(response.subjects, function (index, value) {
                        subjectSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                    })
                    $.each(response.students, function (index, value) {
                        studentSelect.append('<option value="' + value.id + '">' + value.first_name + ' ' + value.last_name + '</option>');
                    })
                    table.DataTable({
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
                        ajax: {
                            url: "{{ route('exams.quarters.first.filtered') }}",
                            data: {class_id: classId},
                            // dataSrc: 'exams'
                        },
                        columns: [
                            {data: 'id'},
                            {
                                data: function (row) {
                                    return {
                                        display : row.students.first_name + ' ' + row.students.last_name
                                    }
                                },
                                render: function (data) {
                                    return data.display;
                                }
                            },
                            {data: 'subjects.name'},
                            {data: 'note'},
                            {data: 'action', orderable: false}
                        ],
                        order: [
                            [0, 'desc'],
                            [1, 'desc']
                        ]
                        ,
                        "createdRow": function (row, data, dataIndex) {
                            $(row).find('td:eq(0)').attr('data-id', data.id);
                            $(row).find('td:eq(1)').attr('data-student', data.students.id);
                            $(row).find('td:eq(2)').attr('data-subject', data.subjects.id);
                            $(row).find('td:eq(3)').attr('data-note', data.note);
                        }
                    });
                }

            });


        }


        function editFunc(event) {
            let clickedButton = event.target;
            let closestRow = $(clickedButton).closest('tr');
            let studentSelected = $('#student');
            let subjectSelect = $('#subject');
            let noteInput = $('#note');
            let noteId = $('#id');
            let rowData = {
                id: closestRow.find('td:eq(0)').data('id'),
                nom: closestRow.find('td:eq(1)').data('student'),
                subject: closestRow.find('td:eq(2)').data('subject'),
                note: closestRow.find('td:eq(3)').data('note')
            };
            studentSelected.val(rowData.nom);
            // studentSelected.prop("disabled", true);
            subjectSelect.val(rowData.subject);
            subjectSelect.find('option[value="' + rowData.subject.toString() + '"]').prop('selected', true);
            // subjectSelect.prop("disabled", true);
            noteInput.val(rowData.note);
            noteId.val(rowData.id).text(rowData.id);
        }


    </script>

@endsection
