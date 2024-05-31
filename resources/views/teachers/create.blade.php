@extends('layouts.app')
@section('title', 'Inscrir un professeur')
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
        <h1>Inscrire un professeur</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('teachers') }}">Professeurs</a></li>
                <li class="breadcrumb-item active">Creer un professeur</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            @isset($teacher)
                <form action="{{ route('teachers.edit', $teacher->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @else
                        <form action="{{ route('teachers.create') }}" method="post" enctype="multipart/form-data">
                            @endisset
                            @csrf
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="first_name" class="col-form-label">Prenom</label>
                                    <input type="text" id="first_name" name="first_name"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           value="{{ old('first_name', $teacher->first_name?? '') }}">
                                    @error('first_name')
                                    <span class="invalid-feedback">{{ $message }}!</span>
                                    @enderror
                                </div>

                                <div class="col-md-5">
                                    <label for="last_name" class="col-form-label">Nom</label>
                                    <input type="text" id="last_name" name="last_name"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           value="{{ old('last_name', $teacher->last_name?? '') }}">
                                    @error('last_name')
                                    <span class="invalid-feedback">{{ $message }}!</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-7">
                                    <div>
                                        <div class="mb-4 d-flex justify-content-center">
                                            <img id="selectedImage"
                                                 src="{{ asset('assets/img/image-placeholder.png') }}"
                                                 alt="Selectioner une image" style="width: 300px;"/>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <div class="btn btn-primary btn-rounded">
                                                <label class="form-label text-white m-1" for="img_path">Choisir une
                                                    profile</label>
                                                <input type="file" id="img_path" name="img_path"
                                                       class="form-control d-none @error('img_path') is-invalid @enderror"
                                                       onchange="displaySelectedImage(event, 'selectedImage')"
                                                       value="{{ old('img_path', $teacher->img_path?? '') }}"/>
                                                @error('img_path')
                                                <span class="invalid-feedback">{{ $message }}!</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-5">
                                    <div class="row">
                                        <label for="nni" class="col-form-label">NNI</label>
                                        <input type="text" id="nni" name="nni"
                                               class="form-control @error('nni') is-invalid @enderror"
                                               value="{{ old('nni', $teacher->nni?? '') }}">
                                        @error('nni')
                                        <span class="invalid-feedback">{{ $message }}!</span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <label for="date_of_birth" class="col-form-label">Date de naissance</label>
                                        <input type="date" id="date_of_birth" name="date_of_birth"
                                               class="form-control @error('date_of_birth') is-invalid @enderror"
                                               value="{{ old('date_of_birth', $teacher->date_of_birth?? '') }}">
                                        @error('date_of_birth')
                                        <span class="invalid-feedback">{{ $message }}!</span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <label for="sex" class="col-form-label">Sexe</label>
                                        <select id="sex" name="sex"
                                                class="form-select @error('sex') is-invalid @enderror">
                                            <option value="">~ Sexe</option>
                                            <option
                                                {{ isset( $teacher->sex) &&  $teacher->sex == "M" ? 'selected' : '' }} value="M">
                                                Masculin
                                            </option>
                                            <option
                                                {{ isset( $teacher->sex) &&  $teacher->sex == "F" ? 'selected' : '' }} value="F">
                                                Feminin
                                            </option>
                                        </select>
                                        @error('sex')
                                        <span class="invalid-feedback">{{ $message }}!</span>
                                        @enderror
                                    </div>

                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col d-flex justify-content-end">
                                    <button type="reset" class="btn btn-secondary">Effacer</button>
                                    <button type="submit" class="btn btn-primary ms-3">Enregistrer</button>
                                </div>
                            </div>

                        </form>

        </div>
    </div>


    <script>
        function displaySelectedImage(event, elementId) {
            const selectedImage = document.getElementById(elementId);
            const fileInput = event.target;

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    selectedImage.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>

@endsection
