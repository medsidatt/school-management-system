@extends('layouts.app')
@section('title', 'Les professeurs de l\'etablissement')

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

    <div id="alert"></div>

    <div class="pagetitle">
        <h1>List des professeurs</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Professeurs</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col"><h5 class="card-title">Tout les professeurs</h5></div>
                            <div class="col mt-2">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('teachers.create') }}" class="btn btn-primary">Ajouter</a>
                                </div>
                            </div>
                        </div>

                        <div style="border: 1px solid black; padding: 3px">
                            <!-- Table with stripped rows -->
                            <table id="teachers" class="display" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>NNI</th>
                                    <th>Sexe</th>
                                    <th>Date de naissance</th>
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

            $('#teachers').DataTable({
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


        });

        function deleteFunc(id) {
            $.confirm({
                title: 'Confirmer!',
                content: 'Voulez vous suprimer cette professeur!',
                buttons: {
                    confirm: {
                        text: 'Suprimer',
                        btnClass: 'btn-success',
                        action: function () {
                            $.ajax({
                                url: "{{ route('teachers.delete') }}",
                                method: 'POST',
                                data: {id: id},

                                success: function () {
                                    $('#teachers').DataTable().ajax.reload();
                                    $('#alert').html('<div class="alert align-center alert-success alert-dismissible fade show" role="alert">' +
                                        '<strong>Alert</strong> <span>vous avez suprimee une professeur</span>' +
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
