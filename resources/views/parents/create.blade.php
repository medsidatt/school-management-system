@extends('layouts.app')
@section('title', 'Inscrir un etudiant')
@section('content')

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ $success }}!
        </div>
    @endif

    @if(Session::has('fails'))
        <div class="alert alert-danger" role="alert">
            {{ $success }}!
        </div>
    @endif

    <div class="pagetitle">
        <h1>Inserer les information d'un parent</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Parent</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->



        <form action="{{ route('parents.create') }}" method="post">
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
                    <label for="nni" class="col-form-label">NNI</label>
                    <input type="number" id="nni" name="nni" class="form-control @error('nni') is-invalid @enderror" value="{{ old('nni') }}">
                    @error('nni')
                    <span class="invalid-feedback">{{ Session::get('success') }}!</span>
                    @enderror
                </div>

                <div class="col-auto">
                    <label for="tel" class="col-form-label">TEL</label>
                    <input type="number" id="tel" name="tel" class="form-control @error('tel') is-invalid @enderror" value="{{ old('tel') }}">
                    @error('tel')
                    <span class="invalid-feedback">{{ $message }}!</span>
                    @enderror
                </div>

                <div class="col-auto">
                    <label for="sex" class="col-form-label">SEXE</label>
                    <select name="sex" id="sex" class="form-select @error('sex') is-invalid @enderror">
                        <option value="">~ Sexe</option>
                        <option value="M">Masculin</option>
                        <option value="F">Feminin</option>
                    </select>
                    @error('sex')
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
