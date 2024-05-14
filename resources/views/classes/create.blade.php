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
                <input type="hidden" id="id" value="@isset($id){{ $id }}@endisset">
            <div class="card-header">
                <h4>Les informations de la classe</h4>
            </div>

            <div class="card-body">
                <div class="row mb-2" style="max-width: 500px">
                    <div class="form-group">
                        <label for="name">Le nom du class</label>
                        <input id="name" name="name" type="text" class="form-control"
                               @if(isset($class_name)) value="{{ $class_name }}" @endif
                        >
                        <span id="name-error" class="text-danger"></span>
                    </div>
                </div>
                <div class="row" style="width: 800px;">
                    <h5>Les matieres et les coefficients sont optionales</h5>
                    @foreach($subjects as $index => $subject)
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-check">
                                    <label class="form-check-label" for="subject{{ $index }}">
                                        {{ $subject->name }}
                                    </label>
                                    <input name="subject[]" class="form-check-input" type="checkbox"
                                           @isset($class_subjects)
                                               @foreach($class_subjects as $class_subject)
                                                   @if($class_subject->subject == $subject->id)
                                                       {{ "checked" }}
                                                   @endif
                                               @endforeach
                                           @endisset
                                           value="{{ $subject->id }}" id="subject{{ $index }}"
                                           data-subject="{{ $index }}">
                                </div>
                            </div>
                            <div class="col-sm-3 p-1" style="width: 50px;">
                                <input name="coefficient[]" class="form-control" id="coef{{ $index }}"
                                       @isset($class_subjects)
                                           @foreach($class_subjects as $class_subject)
                                               @if($class_subject->subject == $subject->id)
                                                   value="{{ $class_subject->coefficient }}"

                                    @endif
                                    @endforeach
                                    @endisset

                                >
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="card-footer">
                <button id="send-button" type="button" class="btn btn-primary">Enregistrer</button>
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
                        coefficientInput.css("border", "1px solid red");
                        isValid = false;
                    } else {
                        coefficientInput.css("border", "");
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
            let id = $('#id').val();
            let data = new FormData(classForm[0]);
            data.append('id', id);
            if (validateFormData()) {
                $.ajax({
                    url: "{{ route('classes.create') }}",
                    data: data,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response)
                        if (response.errors) {
                            clearErrors();
                            $.each(response.errors, function (index, errorMessage) {
                                handleErrors(errorMessage);
                            });
                        } else if (response.success && response.redirect) {
                            clearInputs()
                            window.location.href = response.redirect;
                        }else if (response.notfound && response.redirect) {
                            clearInputs()
                            window.location.href = response.redirect;
                        }
                    }
                });
            }
        });


    </script>

@endsection
