@extends('layouts.app')
@section('title', 'List des etudiants')

@section('content')

    @if(Session::has('success'))
        <x-alert type="success">
            {{ Session::get('success') }}!
        </x-alert>
    @elseif(Session::has('fail'))
        <x-alert type="danger">
            {{ Session::get('fail') }}!
        </x-alert>
    @endif

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
                    lengthMenu: 'Afficher les enregistrements _MENU_ par page',
                    zeroRecords: 'Rien trouvé - désolé',
                    searchPlaceholder: 'Recherche',
                    search: 'Rechercher',
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


    </script>

@endsection
