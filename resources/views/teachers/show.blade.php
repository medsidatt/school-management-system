@extends('layouts.app')
@section('title', 'Informations de professeur')

@section('content')

    <div class="pagetitle">
        <h1>Informations de professeur</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('teachers') }}">Professeurs</a></li>
                <li class="breadcrumb-item">Professeur</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <div class="row mt-2">
                            <div class="col-md-auto">
                                <img class="image"
                                     src="{{ asset($teacher->img_path? 'storage/' .  $teacher->img_path : 'storage/images/t_placeholder.jpeg') }}"
                                     style="width: 300px">
                            </div>
                            <div class="col-md-auto">
                                <div class="mt-3">
                                    <p><span
                                            class="text-secondary">Nom : </span>{{ $teacher->first_name . " ". $teacher->last_name  }}
                                    </p>
                                    <p><span class="text-secondary">NNI : </span>{{ $teacher->nni }}</p>
                                    <p><span class="text-secondary">Date de naissance : </span>
                                        @php
                                            $dateOfBirthArray = explode('-', $teacher->date_of_birth);
                                            $dayOfWeek = date('w', strtotime($teacher->date_of_birth));
                                            $day = $dateOfBirthArray[2];
                                            $month = $dateOfBirthArray[1];
                                            $year = $dateOfBirthArray[0];

                                            $daysOfMonth = array("Dimanche", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Lundi");
                                            $monthsOfYear = array(
                                                "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
                                                "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
                                            );
                                            echo $daysOfMonth[$dayOfWeek] . ' ' . $day . ' ' . $monthsOfYear[$month - 1]. ' ' . $year;
                                        @endphp
                                    </p>
                                </div>
                            </div>
                        </div><!-- End row -->

                        <hr>

                        <div>
                            <h3>Les classes</h3>
                            <button
                                class="btn text-primary d-block my-2" onclick="associateFunc({{ $teacher->id }})">
                                Determiner les classes
                            </button>
                            @if(count($teacher->classes) == 0)
                                <p class=>Cette prof n'est pas encore associer avec
                                    classes </p>
                            @endif

                            @foreach($teacher->classes as $class)
                                <span><a class="btn btn-outline-secondary px-lg-5"
                                         href="{{ route('classes.show', $class->id) }}">{{$class->name}}</a></span>
                            @endforeach
                        </div><!-- End row -->

                        <hr>

                        <div>
                            <h3>Les matieres</h3>
                            <button
                                class="btn text-primary d-block my-2" onclick="associateWithSubFunc({{ $teacher->id }})">
                                Determiner les matieres
                            </button>
                            @if(count($teacher->subjects) == 0)
                                <p class=>Cette prof n'est pas encore associer avec
                                    matieres </p>
                            @endif

                            @foreach($teacher->subjects as $subject)
                                <span><a class="btn btn-outline-secondary px-lg-5">{{$subject->name}}</a></span>
                            @endforeach
                        </div><!-- End row -->

                    </div> <!-- End Card body -->
                </div>
            </div>
        </div>

        <!-- Modal HTML -->
        <div id="myModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Selectioner le(s) classe(s)</h5>
                    </div>
                    <div class="modal-body">
                        <form id="modal-form">
                            @csrf
                            <div id="list-group" class="list-group">

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="hide-modal" type="button" class="btn btn-secondary" onclick="hideModal()">Anulee
                        </button>
                        <button id="send-button" type="button" class="btn btn-primary" onclick="submitForm()">
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal-->
    </section>


    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });


        var listGroup = $('#list-group'), modalForm = $('#modal-form');

        function associateFunc(id) {
            showModal();
            $.ajax({
                url: "{{ route('teachers.associateForm') }}",
                success: function (response) {
                    clearForm();
                    modalForm.append(`<input id="id" type="hidden" name="id" value="${id}">`);
                    $.each(response[0], function (index, value) {
                        listGroup.append(`
                            <label class="list-group-item">
                                <input class="form-check-input me-1" id="class${value.id}" type="checkbox" name="class[]" value="${value.id}">
                                ${value.name}
                            </label>
                        `);
                    });
                },
            });
        }

        function associateWithSubFunc(id) {
            showModal();
            $.ajax({
                url: "{{ route('teachers.associateWithSubForm') }}",
                success: function (response) {
                    clearForm();
                    modalForm.append(`<input id="id" type="hidden" name="id" value="${id}">`);
                    $.each(response[0], function (index, value) {
                        listGroup.append(`
                            <label class="list-group-item">
                                <input class="form-check-input me-1" id="subject${value.id}" type="checkbox" name="subject[]" value="${value.id}">
                                ${value.name}
                            </label>
                        `);
                    });
                },
            });
        }

        function submitForm() {
            var data = new FormData(modalForm[0]);

            $.ajax({
                url: "{{ route('teachers.associateSubmit') }}",
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                },
            });
        }

        function associateWithSubSubmit() {
            var data = new FormData(modalForm[0]);

            $.ajax({
                url: "{{ route('teachers.associateWithSubSubmit') }}",
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                },
            });
        }

        function clearForm() {
        }

        function validateFormData() {
            var elements = $("[id^='class']");
            $.each(elements, function (index, value) {
                console.log($(value).prop('checked'))
            })
        }

        function showModal() {
            $('#myModal').modal('show');
        }

        function hideModal() {
            listGroup.html('');
            $('#myModal').modal('hide');
        }
    </script>

@endsection
