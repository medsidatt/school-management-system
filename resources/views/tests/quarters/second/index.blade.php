@extends('layouts.app')
@section('title', 'List des etudiants')

@section('content')
    <div class="pagetitle">
        <h1 class="mb-1">Les note du 2<sup>em</sup> devoir</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Devoir 2</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    {{--    <p id="cf-response-message"></p>--}}

    <div id="alert"></div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card w-auto">
                    <div class="card-body">
                        <div class="col"><p class="card-title">Tout les note du devoir du 2<sup>em</sup> trimestre</p></div>
                        <div class="row mb-2">
                            <form id="test-form">
                                <input id="id" type="hidden" name="id" value="">
                                <div class="row">
                                    <div class="col-md-8">
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
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <input id="note" type="text" name="note" class="form-control"
                                                   placeholder="La note">
                                        </div>
                                        <div>
                                            <button id="send-button" class="btn btn-primary w-100" type="submit">
                                                Enregistrer
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
                        <div style="border: 1px solid black; padding: 3px">
                            <table id="tests" class="table table-striped">
                                <thead class="table-bordered">
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Matiere</th>
                                    <th>Note</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>


                        <div class="modal fade" id="test-modal" tabindex="-1"
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
                let form = $('#test-form')[0];
                let data = new FormData(form);
                let noteInput = $('#note');
                let selectedSubject = $('#subject');
                let selectedStudent = $('#student');
                let errorFields = {
                    'student': selectedStudent,
                    'note': noteInput,
                    'subject': selectedSubject
                };

                data.append('subject', selectedSubject.val());

                data.append('student', selectedStudent.val());

                $.ajax({
                    url: "{{ route('tests.quarters.second') }}",
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
                        } else if (response.test) {
                            $.alert('la note exist');
                        } else if (response.updated) {
                            $('#tests').DataTable().ajax.reload();
                            $('#subject').prop('disabled', false);
                            $('#student').prop('disabled', false);
                            noteInput.val('');
                            $('#id').val('');
                            $('#alert').html('<div class="alert align-center alert-success alert-dismissible fade show" role="alert">' +
                                '<strong>Modifiee</strong> <span>La note est modifiee avec susses</span>' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>');
                        } else {
                            console.log(response.success);
                            // $('#tests').DataTable().draw();
                            $('#tests').DataTable().ajax.reload();
                            noteInput.val('');
                            $('#subject option:selected').next().attr('selected', 'selected');
                            $('#alert').html('<div class="alert align-center alert-success alert-dismissible fade show" role="alert">' +
                                '<strong>Ajouter</strong> <span>La note est ajoutee avec susses</span>' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>');
                        }
                    }
                });
            });

            function handleFieldError(fieldElement, errorMessage) {
                fieldElement.toggleClass('is-invalid', errorMessage !== null);
                fieldElement.toggleClass('is-valid', errorMessage === null);
            }

        });

        function classFunc(event) {
            let classId = event.target.value;
            let subjectSelect = $('#subject');
            let studentSelect = $('#student');
            let table = $('#tests');

            if (classId === '' && $.fn.DataTable.isDataTable('#tests')) {

                table.find('tbody')
                    .html('<tr><td colspan="5" class="dt-empty">Il faut selectioner une classe s\'il vous plait</td></tr>');
            } else {
                $.ajax({
                    url: "{{ route('tests.quarters.second.filtered', '') }}",
                    data: {class_id: classId},
                    method: 'GET',
                    success: function (response) {
                        if ($.fn.DataTable.isDataTable('#tests')) {
                            table.DataTable().destroy();
                        }
                        studentSelect.empty();
                        subjectSelect.empty();
                        studentSelect.append('<option selected value="">Etudiant ~</option>');
                        subjectSelect.append('<option selected value="">Matiere ~</option>');
                        $.each(response.subjects, function (index, value) {
                            subjectSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        }),
                            $.each(response.students, function (index, value) {
                                studentSelect.append('<option value="' + value.id + '">' + value.id + ' - ' + value.first_name + ' ' + value.last_name + '</option>');
                            }),
                            table.DataTable({
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
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: "{{ route('tests.quarters.second.filtered') }}",
                                    data: {class_id: classId},
                                },
                                scrollY: 400,
                                pagingType: 'simple_numbers',
                                columns: [
                                    {data: 'stu_id'},
                                    {
                                        data: 'stu.fn',
                                        render: function (data, type, row, meta) {
                                            return row.stu_fn + ' ' + row.stu_ln;
                                        }
                                    },
                                    {data: 'sub_name'},
                                    {data: 'note', searching: false},
                                    {data: 'action', orderable: false}
                                ]
                                ,
                                "createdRow": function (row, data, td) {
                                    $(row).find('td:eq(0)').attr('data-student-id', data.id);
                                    $(row).find('td:eq(1)').attr('data-student', data.stu_id);
                                    $(row).find('td:eq(2)').attr('data-subject', data.sub_id);
                                    $(row).find('td:eq(3)').attr({'data-note': data.note, 'data-id': data.id});
                                    $(row).find('td').css('padding', '1px');
                                }
                            });
                    }

                });
            }


        }

        function editFunc(event) {
            let clickedButton = event.target;
            let closestRow = $(clickedButton).closest('tr');
            let studentSelected = $('#student');
            let subjectSelect = $('#subject');
            let noteInput = $('#note');
            let noteId = $('#id');
            let rowData = {
                id: closestRow.find('td:eq(3)').data('id'),
                nom: closestRow.find('td:eq(1)').data('student'),
                subject: closestRow.find('td:eq(2)').data('subject'),
                note: closestRow.find('td:eq(3)').data('note')
            };
            studentSelected.val(rowData.nom);
            studentSelected.prop("disabled", true);
            subjectSelect.val(rowData.subject);
            subjectSelect.find('option[value="' + rowData.subject.toString() + '"]').prop('selected', true);
            subjectSelect.prop("disabled", true);
            noteInput.val(rowData.note);
            noteId.val(rowData.id).text(rowData.id);
        }

        function deleteFunc(id) {
            $.confirm({
                title: 'Confirmer!',
                content: 'Voulez vous suprimer cette note!',
                buttons: {
                    confirm: {
                        text: 'Suprimer',
                        btnClass: 'btn-success',
                        action: function () {
                            $.ajax({
                                url: "{{ route('tests.quarters.second.delete') }}",
                                method: 'POST',
                                data: {id: id},

                                success: function () {
                                    $('#tests').DataTable().ajax.reload();
                                    $('#alert').html('<div class="alert align-center alert-success alert-dismissible fade show" role="alert">' +
                                        '<strong>Alert</strong> <span>vous avez suprimee une note</span>' +
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
