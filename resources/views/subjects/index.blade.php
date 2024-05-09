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


    <div id="alert"></div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col"><h5 class="card-title">Tout les matieres</h5></div>
                            <div class="col  d-flex mt-1 justify-content-end">
                                <!-- Button HTML (to Trigger Modal) -->
                                <div>
                                    <button type="button" id="show-modal" class="btn show-modal btn-primary p-1">
                                        Ajoute
                                    </button>
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
                                                        <small id="name-error" class="invalid-feedback"></small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="code">Le code du matiere</label>
                                                        <input name="code" class="form-control" id="code"
                                                               placeholder="Le code du matiere">
                                                        <small id="code-error" class="invalid-feedback"></small>
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
                            </div>

                        </div>


                        <div style="border: 1px solid black; padding: 3px">
                            <table id="subjects" class="table table-striped table-responsive display"
                                   style="width:100%">
                                <thead class="table-bordered">
                                <tr>
                                    <th>#</th>
                                    <th>Label</th>
                                    <th>Code</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>


                    </div>
                </div>

            </div>
        </div>


        <div class="bs-example">

        </div>
    </section>







    <script>

        function emptyFields() {
            $('#name').val('');
            $('#code').val('');
            $('#id').val('');
        }

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let table = $('#subjects');

            $.ajax({
                url: "{{ route('subjects') }}",
                serverSide: true,
                layout: {
                    topStart: {
                        buttons: [
                            {
                                text: 'My button',
                                action: function (e, dt, node, config) {
                                    alert('Button activated');
                                }
                            }
                        ]
                    }
                },
                success: function (response) {
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
                        scrollY: 400,
                        pagingType: 'simple_numbers',
                        ajax: "{{ route('subjects') }}",
                        columns: [
                            {data: 'id', name: 'id'},
                            {data: 'name', name: 'name'},
                            {data: 'code', name: 'code'},
                            {data: 'action', orderable: false},
                        ],
                    });
                },
                error: function (xhr, status, error) {
                    console.error('error');
                }
            });


            $("#show-modal").click(function () {
                $("#myModal").modal('show');
            });

            $("#hide-modal").click(function () {
                $("#myModal").modal('hide');
            });


            $("#send-button").click(function () {
                let data = new FormData($('#modal-form')[0]);
                let errorFields = {
                    name: $('#name'),
                    code: $('#code')
                };

                let errorFeedBacks = {
                    name: $('#name-error'),
                    code: $('#code-error')
                };

                $.ajax({
                    url: "{{ route('subjects') }}",
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // console.log(response);
                        if (response.errors) {

                            $.each(response.errors, function (field, errorMessage) {
                                console.log(errorFields[field]);
                                console.log(errorMessage);
                                console.log(errorFeedBacks[field]);
                                handleFieldError(errorFields[field], errorMessage, errorFeedBacks[field]);

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
        });

        function handleFieldError(errorField, errorMessage, errorFeedBacks) {
            errorField.toggleClass('is-invalid', errorMessage !== null);
            errorFeedBacks.text(errorMessage, errorMessage !== null);
            errorField.toggleClass('is-valid', errorMessage === null);
            errorFeedBacks.text('', errorMessage === null);

        }

        function editFunc(id, event) {
            let clickedButton = event.target;
            let row = $(clickedButton).closest('tr');
            $('#id').val(row.find('td:eq(0)').text());
            $('#name').val(row.find('td:eq(1)').text());
            $('#code').val(row.find('td:eq(2)').text());

            console.log(row.find('td:eq(1)').text());
            $("#myModal").modal('show');

        }

        function deleteFunc(id) {
            $.confirm({
                title: 'Confirmer!',
                content: 'Voulez vous suprimer cette matiere!',
                buttons: {
                    confirm: {
                        text: 'Suprimer',
                        btnClass: 'btn-success',
                        action: function () {
                            $.ajax({
                                url: "{{ route('subjects.delete') }}",
                                method: 'POST',
                                data: {id: id},

                                success: function () {
                                    $('#subjects').DataTable().ajax.reload();
                                    $('#alert').html('<div class="alert align-center alert-success alert-dismissible fade show" role="alert">' +
                                        '<strong>Alert</strong> <span>vous avez suprimee une matiere</span>' +
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
