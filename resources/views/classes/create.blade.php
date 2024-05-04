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


    @if(isset($class))
        <form action="{{ route('classes.edit', $class->id) }}" method="post">
            @method('put')
            <input type="hidden" name="id" value="{{ $class->id }}">
            @else
                <form action="{{ route('classes.create') }}" method="post">
                    @endif
                    @csrf
                    <div class="row">
                        <h4>Les informaions de la classe</h4>
                    </div>
                    <div class="row g-3 align-items-start">
                        <div class="col-md-3 justify-start">
                            <label for="name" class="col-form-label">Labele</label>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $class->name ?? '')}}">
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}!</span>
                            @enderror
                        </div>

                        <div class="col-md-7 m-lg-2">
                            <fieldset>
                                <legend class="col-form-label col-sm-2 pt-0">Les Matieres</legend>
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2">
                                        @foreach($subjects as $subject)
                                            <div class="form-check">
                                                <input class="form-check-input" name="subject[]" type="checkbox"
                                                       {{ (isset($class_subjects) && in_array($subject->id, $class_subjects)) ? 'checked' : '' }} id="gridCheck_{{ $subject->code }}"
                                                       value="{{ $subject->id }}">
                                                <label class="form-check-label" for="gridCheck_{{ $subject->code }}">
                                                    {{ $subject->name }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </fieldset>
                        </div>



                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
        @endsection
