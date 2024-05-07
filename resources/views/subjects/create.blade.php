@extends('layouts.app')
@section('title', 'Inscrir un etudiant')
@section('content')

    @isset($success)
        <div class="alert alert-success" role="alert">
            {{ $success }}!
        </div>
    @endisset

    <div class="pagetitle">
        <h1>Creer un etudiant</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Creer un etudiant</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->



        <form action="{{ route('students.create') }}" method="post">
            @csrf
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="first_name" class="col-form-label">Prenom</label>
                    <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
                    @error('first_name')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>

                <div class="col-auto">
                    <label for="last_name" class="col-form-label">Nom</label>
                    <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
                    @error('last_name')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>

                <div class="col-auto">
                    <label for="rim" class="col-form-label">RIM</label>
                    <input type="text" id="rim" name="rim" class="form-control @error('rim') is-invalid @enderror" value="{{ old('rim') }}">
                    @error('rim')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>

                <div class="col-auto">
                    <label for="sex" class="col-form-label">Sexe</label>
                    <select name="sex" class="form-select @error('sex') is-invalid @enderror">
                        <option value="">~ Sexe</option>
                        <option value="M">Masculin</option>
                        <option value="F">Feminin</option>
                    </select>
                    @error('sex')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>

                <div class="col-auto">
                    <label for="class" class="col-form-label">Classe</label>
                    <select name="class" class="form-select @error('class') is-invalid @enderror">
                        <option value="">~ Classe</option>
                        <option value="1">1 AS</option>
                        <option value="2">2 AS</option>
                        <option value="3">3 AS</option>
                        <option value="4">4 AS</option>
                    </select>
                    @error('class')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>

                <div class="col-auto">
                    <label for="date_of_birth" class="col-form-label">Date de naissance</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>





            </div>
            <button class="btn btn-primary mt-3">Enregistrer</button>
        </form>


@endsection
