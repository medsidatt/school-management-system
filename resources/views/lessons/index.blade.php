@extends('layouts.app')
@section('title', 'Ajouter une lesson dans l\'emploi de temp')

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
        <h1>Lesson</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Ajouter une lesson dans l'emploi de temp</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div id="alert"></div>
    <section class="section">
       <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Ajouter une lesson dans l'emploi de temp
                </div>
            </div>
           <div class="card-body mt-2">

               <form action="{{ route('lessons.create') }}" method="post">
                   @csrf
                   <div class="row mt-2">
                       <label for="day" class="form-label">Jour</label>
                       <select id="day" class="form-select @error('day') is-invalid @enderror" name="day">
                           <option value="" {{ old('day') == '' ? 'selected' : '' }}>Selectionner le jour</option>
                           <option value="Lundi" {{ old('day') == 'Lundi' ? 'selected' : '' }}>Lundi</option>
                           <option value="Mardi" {{ old('day') == 'Mardi' ? 'selected' : '' }}>Mardi</option>
                           <option value="Mercredi" {{ old('day') == 'Mercredi' ? 'selected' : '' }}>Mercredi</option>
                           <option value="Jeudi" {{ old('day') == 'Jeudi' ? 'selected' : '' }}>Jeudi</option>
                           <option value="Vendredi" {{ old('day') == 'Vendredi' ? 'selected' : '' }}>Vendredi</option>
                           <option value="Samedi" {{ old('day') == 'Samedi' ? 'selected' : '' }}>Samedi</option>
                       </select>
                       <div class="invalid-feedback">@error('day') {{ $message }} @enderror</div>
                   </div>

                   <div class="row mt-2">
                       <label for="classes_id" class="form-label">Classe</label>
                       <select id="classes_id" class="form-select @error('classes_id') is-invalid @enderror" name="classes_id">
                           <option value="" {{ old('classes_id') == '' ? 'selected' : '' }}>Selectionner une classe</option>
                           @foreach($classes as $class)
                               <option value="{{ $class->id }}" {{ old('classes_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                           @endforeach
                       </select>
                       <div class="invalid-feedback">@error('class_id') {{ $message }} @enderror</div>
                   </div>

                   <div class="row mt-2">
                       <label for="teacher_id" class="form-label">Professeur</label>
                       <select id="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror" name="teacher_id">
                           <option value="" {{ old('teacher_id') == '' ? 'selected' : '' }}>Selectionner un professeur</option>
                           @foreach($teachers as $teacher)
                               <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                   {{ $teacher->first_name . ' ' . $teacher->last_name }}
                               </option>
                           @endforeach
                       </select>
                       <div class="invalid-feedback">@error('teacher_id') {{ $message }} @enderror</div>
                   </div>

                   <div class="row mt-2">
                       <label for="subject_id" class="form-label">Matière</label>
                       <select id="subject_id" class="form-select @error('subject_id') is-invalid @enderror" name="subject_id">
                           <option value="" {{ old('subject_id') == '' ? 'selected' : '' }}>Selectionner une matière</option>
                           @foreach($subjects as $subject)
                               <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                           @endforeach
                       </select>
                       <div class="invalid-feedback">@error('subject_id') {{ $message }} @enderror</div>
                   </div>

                   <div class="row mt-2">
                       <label for="start">Heure de début</label>
                       <input id="start" class="form-control @error('start') is-invalid @enderror" type="time" name="start" value="{{ old('start') }}" min="00:00" max="23:59">
                       <div class="invalid-feedback">@error('start') {{ $message }} @enderror</div>
                   </div>

                   <div class="row mt-2">
                       <label for="end">Heure de fin</label>
                       <input id="end" class="form-control @error('end') is-invalid @enderror" type="time" name="end" value="{{ old('end') }}" min="00:00" max="23:59">
                       <div class="invalid-feedback">@error('end') {{ $message }} @enderror</div>
                   </div>

                   <button class="btn btn-primary mt-2" type="submit">Enregistrer</button>
               </form>


           </div>
       </div>
    </section>





    <script>


    </script>

@endsection
