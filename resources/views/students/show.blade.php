@extends('layouts.app')
@section('title', 'List des etudiants')

@section('content')

    <div class="pagetitle">
        <h1>Informations d'etudiant</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('students') }}">Eleves</a></li>
                <li class="breadcrumb-item">Eleve</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <div class="row mt-2">
                            <div class="col-md-auto">
                                <img class="image" src="{{ asset('assets/img/profile-img.jpg') }}" style="width: 300px">
                            </div>
                            <div class="col-md-auto">
                                <div class="mt-3">
                                    <p><span class="text-secondary">Nom : </span>{{ $student->first_name . " ". $student->last_name  }}</p>
                                    <p><span class="text-secondary">RIM : </span>{{ $student->rim }}</p>
                                    <p><span class="text-secondary">Date de naissance : </span>{{ $student->date_of_birth }}</p>
                                    <p><span class="text-secondary">Classe : </span>{{ $student->name }}</p>
                                    <p><span class="text-secondary">Sexe : </span>{{ $student->sex }}</p>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
