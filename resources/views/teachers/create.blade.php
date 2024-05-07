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
        <h1>Creer un professeur</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('teachers') }}">Professeurs</a></li>
                <li class="breadcrumb-item active">Creer un professeur</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


@isset($teacher)
        <form action="{{ route('teachers.edit', $teacher->id) }}" method="post">
            @method('put')
            @else
        <form action="{{ route('teachers.create') }}" method="post">
            @endisset
            @csrf
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="first_name" class="col-form-label">Prenom</label>
                    <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                           value="{{ old('first_name', $teacher->first_name?? '') }}">
                    @error('first_name')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>

                <div class="col-auto">
                    <label for="last_name" class="col-form-label">Nom</label>
                    <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                           value="{{ old('last_name', $teacher->last_name?? '') }}">
                    @error('last_name')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>

                <div class="col-auto">
                    <label for="nni" class="col-form-label">NNI</label>
                    <input type="text" id="nni" name="nni" class="form-control @error('nni') is-invalid @enderror"
                           value="{{ old('nni', $teacher->nni?? '') }}">
                    @error('nni')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>

                <div class="col-auto">
                    <label for="date_of_birth" class="col-form-label">Date de naissance</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                           value="{{ old('date_of_birth', $teacher->date_of_birth?? '') }}">
                    @error('date_of_birth')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>
                <div class="col-auto">
                    <label for="sex" class="col-form-label">Sexe</label>
                    <select id="sex" name="sex" class="form-select @error('sex') is-invalid @enderror">
                        <option value="">~ Sexe</option>
                        <option {{ isset( $teacher->sex) &&  $teacher->sex == "M" ? 'selected' : '' }} value="M">Masculin</option>
                        <option {{ isset( $teacher->sex) &&  $teacher->sex == "F" ? 'selected' : '' }} value="F">Feminin</option>
                    </select>
                    @error('sex')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>

            </div>
            <div class="row mt-3">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="reset" class="btn btn-secondary">Effacer</button>
                </div>
            </div>

        </form>


@endsection
