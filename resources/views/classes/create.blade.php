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
            <div class="card-header">
                <h4>Les informaions de la classe</h4>
            </div>

            <div class="card-body">
                <div class="row mb-2 w-50">
                    <div class="form-group">
                        <label class="" for="class-name">Le nom du class</label>
                        <input type="text" class="form-control" id="class-name">
                    </div>
                </div>
                <div id="form-body"></div>
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
                    <input class="form-check-input" type="checkbox" value="${value.id}" id="subject${index}">
                    <label class="form-check-label" for="subject${index}">
                        ${value.name}
                    </label>
                </div>
            </div>
            <div class="col-sm-5">
                <input type="text" name="coef${index}" class="form-control-sm" id="coef${index}">
            </div>
        </div>`);
        } {{-- Row generator function --}}


        function validateFormData() {
            let isValid = true;
            const subjectCount = $('[id^="subject"]').length;

            for (let i = 0; i < subjectCount; i++) {
                const checkbox = document.getElementById(`subject${i}`);
                const coefficientInput = document.getElementById(`coef${i}`);
                if (checkbox.checked) {
                    const coefficient = parseFloat(coefficientInput.value);
                    if (isNaN(coefficient) || coefficient < 1 || coefficient > 8) {
                        coefficientInput.style.border = '1px solid red';
                        isValid = false;
                    } else {
                        coefficientInput.style.border = '';
                    }
                }
            }
            return isValid;
        }

        classForm.ready(function () {

            $.ajax({
                url: "{{ route('classes.create') }}",
                type: 'GET',
                success: function (response) {
                    $.each(response.subjects, function (index, value) {
                        createRow(index, value);
                    });
                }
            });
        }); {{-- Subjects --}}

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
                        console.log(response);
                    }
                });
            } else {
                console.log('not validated');
            }
        });

    </script>
@endsection
