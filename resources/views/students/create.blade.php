@extends('layouts.app')
@section('title', 'Inscrir un etudiant')
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
        <h1>Creer un etudiant</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Creer un etudiant</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    @if(isset($student))
        <form action="{{ route('students.edit', $student->id) }}" method="post">
            @method('put')
            <input type="hidden" name="id" value="{{ $student->id }}">
            <input type="hidden" name="p_id" value="{{ $student->parents->id }}">
            @else
                <form action="{{ route('students.create') }}" method="post">
                    @endif
                    @csrf
                    <div class="row">
                        <h4>Les informaions d'etudiant</h4>
                    </div>
                    <div class="row g-3 align-items-center">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="first_name" class="col-form-label">Prenom</label>
                                    <input type="text" id="first_name" name="first_name"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           value="{{ old('first_name', $student->first_name ?? '')}}">
                                    @error('first_name')
                                    <span class="invalid-feedback">{{ $message }}!</span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="last_name" class="col-form-label">Nom</label>
                                    <input type="text" id="last_name" name="last_name"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           value="{{ old('last_name', $student->last_name ?? '') }}">
                                    @error('last_name')
                                    <span class="invalid-feedback">{{ $message }}!</span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="rim" class="col-form-label">RIM</label>
                                    <input type="text" id="rim" name="rim"
                                           class="form-control @error('rim') is-invalid @enderror"
                                           value="{{ old('rim', $student->rim ?? '') }}">
                                    @error('rim')
                                    <span class="invalid-feedback">{{ $message }}!</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="sex" class="col-form-label">Sexe</label>
                                    <select id="sex" name="sex" class="form-select @error('sex') is-invalid @enderror">
                                        <option value="">~ Sexe</option>
                                        <option {{ isset( $student->sex) &&  $student->sex == "M" ? 'selected' : '' }} value="M">Masculin</option>
                                        <option {{ isset( $student->sex) &&  $student->sex == "F" ? 'selected' : '' }} value="F">Feminin</option>
                                    </select>
                                    @error('sex')
                                    <span class="invalid-feedback">{{ $message }}!</span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="class" class="col-form-label">Classe</label>
                                    <select id="class" name="class" class="form-select @error('class') is-invalid @enderror">
                                        <option value="">~ Classe</option>
                                        @foreach($classes as $class)
                                            <option {{ isset($student->classes->id) && $student->classes->id == $class->id ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('class')
                                    <span class="invalid-feedback">{{ $message }}!</span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="date_of_birth" class="col-form-label">Date de naissance</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth"
                                           class="form-control @error('date_of_birth') is-invalid @enderror"
                                           value="{{ old('date_of_birth', $student->date_of_birth ?? '') }}">
                                    @error('date_of_birth')
                                    <span class="invalid-feedback">{{ $message }}!</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="">


                        <div class="row">
                            <h4>Les information de parent</h4>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="p_first_name" class="col-form-label">Prenom</label>
                                        <input type="text" id="p_first_name" name="p_first_name"
                                               class="form-control @error('p_first_name') is-invalid @enderror"
                                               value="{{ old('p_first_name', $student->parents->first_name ?? '') }}">
                                        @error('p_first_name')
                                        <span class="invalid-feedback">{{ $message }}!</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="p_last_name" class="col-form-label">Nom</label>
                                        <input type="text" id="p_last_name" name="p_last_name"
                                               class="form-control @error('p_last_name') is-invalid @enderror"
                                               value="{{ old('p_last_name', $student->parents->last_name ?? '') }}">
                                        @error('p_last_name')
                                        <span class="invalid-feedback">{{ $message }}!</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="p_nni" class="col-form-label">NNI</label>
                                        <input type="number" id="p_nni" name="p_nni"
                                               class="form-control @error('p_nni') is-invalid @enderror"
                                               value="{{ old('p_nni', $student->parents->nni ?? '') }}">
                                        @error('p_nni')
                                        <span class="invalid-feedback">{{ $message }}!</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="p_tel" class="col-form-label">TEL</label>
                                        <input type="number" id="p_tel" name="p_tel"
                                               class="form-control @error('p_tel') is-invalid @enderror"
                                               value="{{ old('p_tel', $student->parents->tel ?? '') }}">
                                        @error('p_tel')
                                        <span class="invalid-feedback">{{ $message }}!</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="p_sex" class="col-form-label">Sexe</label>
                                        <select name="p_sex" id="p_sex"
                                                class="form-select @error('p_sex') is-invalid @enderror">
                                            <option value="">~ Sexe</option>
                                            <option {{ isset( $student->parents->sex) &&  $student->parents->sex == "M" ? 'selected' : '' }} value="M">Masculin</option>
                                            <option {{ isset( $student->parents->sex) &&  $student->parents->sex == "F" ? 'selected' : '' }} value="F">Feminin</option>
                                        </select>
                                        @error('p_sex')
                                        <span class="invalid-feedback">{{ $message }}!</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="p_date_of_birth" class="col-form-label">Date de naissance</label>
                                        <input type="date" id="p_date_of_birth" name="p_date_of_birth"
                                               class="form-control @error('p_date_of_birth') is-invalid @enderror"
                                               value="{{ old('p_date_of_birth', $student->parents->date_of_birth ?? '') }}">
                                        @error('p_date_of_birth')
                                        <span class="invalid-feedback">{{ $message }}!</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-3">Enregistrer</button>
                </form>
        @endsection
