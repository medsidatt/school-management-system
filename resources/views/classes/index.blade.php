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

    <div id="alert"></div>
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
                        <div style="padding: 3px; border: 1px solid black">
                            <table id="classes" class="table table-striped table-responsive">
                                <thead class="table-bordered">
                                <tr>
                                    <th>Nom</th>
                                    <th>Date de creation</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>
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

            $('#classes').DataTable({
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
                ajax: "{{ route('classes') }}",
                serverSide: true,
                columns: [
                    {data: 'name'},
                    {
                        data: 'created_at',
                        name: 'created_at',
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
        })


        function deleteFunc(id) {
            $.confirm({
                title: 'Confirmer!',
                content: 'Voulez vous suprimer cette classe!',
                buttons: {
                    confirm: {
                        text: 'Suprimer',
                        btnClass: 'btn-success',
                        action: function () {
                            $.ajax({
                                url: "{{ route('classes.delete') }}",
                                method: 'POST',
                                data: {id: id},

                                success: function (response) {
                                    $('#classes').DataTable().ajax.reload();
                                    $('#alert').html('<div class="alert align-center alert-success alert-dismissible fade show" role="alert">' +
                                        '<strong>Alert</strong> <span>vous avez suprimee une classe</span>' +
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



