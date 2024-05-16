@extends('layouts.app')
@section('title', 'List des etudiants')

@section('content')

    <div class="pagetitle">
        <h1>List des eleves</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Eleve</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div id="alert"></div>
    @if(Session::has('success'))
        <x-alert type="success">
            {{ Session::get('success') }}!
        </x-alert>
    @elseif(Session::has('fail'))
        <x-alert type="danger">
            {{ Session::get('fail') }}!
        </x-alert>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card w-auto">
                    <div class="card-body">

                        <div class="row">
                            <div class="col"><h5 class="card-title">Tout les eleves</h5></div>
                            <div class="col mt-2">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('students.create') }}" class="btn btn-primary">Ajouter</a>
                                </div>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <div style="padding: 3px; border: 1px solid black">
                            <table id="students" class="table table-striped">
                                <thead class="table-bordered">
                                <tr>
                                    <th>#</th>
                                    <th>RIM</th>
                                    <th>Nom</th>
                                    <th>Sexe</th>
                                    <th>Classe</th>
                                    <th data-type="date" data-format="YYYY/DD/MM">Date de naissance</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                            <div class="modal fade" id="student-modal" tabindex="-1"
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



            $('#students').DataTable({
                language: {
                    info: 'Affichage de la page _PAGE_ sur _PAGES_',
                    infoEmpty: 'Aucun enregistrement disponible',
                    infoFiltered: '(filtré à partir de _MAX_ enregistrements totaux)',
                    lengthMenu: 'Afficher _MENU_ par page',
                    zeroRecords: 'Rien trouvé - désolé',
                    searchPlaceholder: 'Recherche',
                    search: 'Rechercher',
                },
                scrollY: 400,
                layout: {
                    topEnd: {
                        buttons: [

                            {
                                extend: ["csv"],
                                exportOptions: {
                                    columns: [0,1,2,3,4,5]
                                },
                                action: newexportation
                            },
                            {
                                extend: 'excelHtml5',
                                exportOptions: {
                                    columns: [0,1,2,3,4,5],
                                },
                                // titleAttr: 'Excel',
                                action: newexportation,
                            },
                            {
                                extend: ["pdf"],
                                exportOptions: {
                                    columns: [0,1,2,3,4,5],
                                },
                                action: newexportation,
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [0,1,2,3,4,5],
                                },
                                action: newexportation,
                            }
                        ],
                        search: {
                            placeholder: 'Rechercher'
                        },
                    },

                },
                processing: true,
                serverSide: true,
                ajax: "{{ url('students') }}",
                columns: [
                    { data: 'id' },
                    { data: 'rim' },
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
                    { data: 'sex' },
                    { data: 'classes.name' },
                    { data: 'date_of_birth' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]
            });

        });

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

        function newexportation(e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;
            dt.one('preXhr', function (e, s, data) {
                // Just this once, load all data from the server...
                data.start = 0;
                data.length = 2147483647;
                dt.one('preDraw', function (e, settings) {
                    // Call the original action function
                    if (button[0].className.indexOf('buttons-copy') >= 0) {
                        $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                        $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                        $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                        $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-print') >= 0) {
                        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                    }
                    dt.one('preXhr', function (e, s, data) {
                        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                        // Set the property to what it was before exporting.
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });
                    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                    setTimeout(dt.ajax.reload, 0);
                    // Prevent rendering of the full data to the DOM
                    return false;
                });
            });

            $(button).removeClass('processing');
            $('#students_processing').html('');

            // Requery the server with the new one-time export settings
            dt.ajax.reload();

        }


    </script>

@endsection
