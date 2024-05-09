@extends('layouts.app')
@section('title', 'Creer une classe ')
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
        <h1>Creer une classe</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classes') }}">Classes</a></li>
                <li class="breadcrumb-item active">Creer une classe</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->



    <div class="card">
        <form id="class-form">
            <input type="hidden" name="id">
            <div class="card-header">
                <h4>Les informaions de la classe</h4>
            </div>

            <div class="card-body">
                <div class="row mb-2 w-50">
                    <div class="form-group">
                        <label class="" for="class-name">Le nom du class</label>
                        <input name="name" type="text" class="form-control" id="name">
                        <span id="name-error" class="invalid-feedback"></span>
                    </div>
                </div>
                <div id="form-body">
                    <div class="container">
                        @foreach($subjects as $index => $subject)
                            <div class="row border-radius border-1 border-secondary mb-2">
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input name="subject[]" class="form-check-input" type="checkbox" value="{{ $subject['id'] }}" id="subject{{ $index }}">
                                        <label class="form-check-label" for="subject{{ $index }}">
                                            {{ $subject['name'] }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="coeficient[]" class="form-control" id="coef{{ $index }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button id="send-button" type="button" class="btn btn-primary">Enregistrer</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </div>





    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        let classForm = $('#class-form');
        let formBody = $('#form-body');

        function createRow(index, value) {
            formBody.append(`<div class="row border-radius border-1 border-secondary mb-2">
            <div class="col-sm-6">
                <div class="form-check">
                    <input name="subject[]" class="form-check-input" type="checkbox" value="${value.id}" id="subject${index}">
                    <label class="form-check-label" for="subject${index}">
                        ${value.name}
                    </label>
                </div>
            </div>
            <div class="col-sm-5">
                <input type="text" name="coeficient[]" class="form-control-sm" id="coef${index}">
            </div>
        </div>`);
        } {{-- Row generator function --}}


        function validateFormData() {
            let nameField = $('#name');
            let errorMessage = $('#name-error');
            let isValid = true;
            const subjectCount = $('[id^="subject"]').length;

            for (let i = 0; i < subjectCount; i++) {
                const checkbox = $(`#subject${i}`);
                const coefficientInput = $(`#coef${i}`);

                if (checkbox.prop('checked')) {
                    const coefficient = parseInt(coefficientInput.val());
                    if (isNaN(coefficient) || coefficient < 1 || coefficient > 8) {
                        coefficientInput.addClass('is-invalid');
                        isValid = false;
                    } else {
                        coefficientInput.removeClass('is-invalid');
                    }
                }
            }
            if (nameField.val() === ''){
                nameField.addClass('is-invalid');
                errorMessage.text('Le nom du class est obligatoire');
            }else {
                nameField.removeClass('is-invalid');
                errorMessage.text('');
            }

            return isValid;
        }

        {{--classForm.ready(function () {--}}

        {{--    $.ajax({--}}
        {{--        url: "{{ route('classes.create') }}",--}}
        {{--        type: 'GET',--}}
        {{--        success: function (response) {--}}
        {{--            $.each(response.subjects, function (index, value) {--}}
        {{--                createRow(index, value);--}}
        {{--            });--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

        let nameField = $('#name');
        let nameError = $('#name-error');

        function clearErrors() {
            nameField.removeClass('is-invalid');
            nameError.text('');
        }

        function clearInputs() {
            $('#id').val('');
            nameField.val('');
            $('#subjects').val('');
        }

        function handleErrors(errorMessage) {
            nameField.addClass('is-invalid');
            nameError.text(errorMessage);
        }

        {{-- Subjects --}}


        $('#send-button').on('click', function () {
            let data = new FormData(classForm[0]);
            if (validateFormData()) {
                $.ajax({
                    url: "{{ route('classes.create') }}",
                    data: data,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if(response.errors) {
                            clearErrors();
                            $.each(response.errors, function (index, errorMessage) {
                                handleErrors(errorMessage);
                                console.log(errorMessage);
                            });
                        }else if (response.success && response.redirect) {
                            clearInputs()
                            window.location.href = response.redirect;
                        }
                    }
                });
            } else {
                console.log('not validated');
            }
        });


    </script>
@endsection
