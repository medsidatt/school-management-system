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
                        <input id="name" name="name" type="text" class="form-control">
                        <span id="name-error" class="text-danger"></span>
                    </div>
                </div>
                <div class="row py-1">
                    <div class="col-sm-6">
                        <h5>Les matieres</h5>
                    </div>
                    <div class="col-sm-3">
                        <h5>Les coefficients</h5>
                    </div>
                </div>
                <div class="row">
                    @foreach($subjects as $index => $subject)
                        <div class="col-sm-5">
                            <div class="form-check">
                                <label class="form-check-label" for="subject{{ $index }}">
                                    {{ $subject['name'] }}
                                </label>
                                <input name="subject[]" class="form-check-input" type="checkbox"
                                       value="{{ $subject['id'] }}" id="subject{{ $index }}"
                                       data-subject="{{ $index }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input name="coefficient[]" class="form-control" id="coef{{ $index }}">
                        </div>
                    @endforeach
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


        let classForm = $('#class-form'), nameField = $('#name'),
            nameError = $('#name-error');
        const subjectCount = $('[id^="subject"]').length;

        function validateFormData() {
            let isValid = true;

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
            if (nameField.val() === '') {
                nameField.addClass('is-invalid');
                nameError.text('Le nom du class est obligatoire');
                isValid = false;
            } else {
                nameField.removeClass('is-invalid');
                nameError.text('');
            }

            return isValid;
        }


        function clearErrors() {
            nameField.removeClass('is-invalid');
            nameError.text('');
        }

        function clearInputs() {
            $('#id').val('');
            nameField.val('');
            $('#subjects').val('');

            for (let i = 0; i < subjectCount; i++) {
                $(`#subject${i}`).prop('checked', false);
                $(`#coef${i}`).val('');
            }

        }

        function handleErrors(errorMessage) {
            nameField.addClass('is-invalid');
            nameError.text(errorMessage);
        }

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
                        if (response.errors) {
                            clearErrors();
                            $.each(response.errors, function (index, errorMessage) {
                                handleErrors(errorMessage);
                                console.log(errorMessage);
                            });
                        } else if (response.test) {
                            console.log(response.test)
                        }else if (response.success && response.redirect) {
                            clearInputs()
                            window.location.href = response.redirect;
                        } else if (response.data) {
                            console.log(response)
                        }
                    }
                });
            }
        });


    </script>

@endsection
