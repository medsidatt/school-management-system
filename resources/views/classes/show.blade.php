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

                        <div class="row">
                            <div class="col"><h5 class="card-title">Le nom de l'etudiant</h5></div>

                        </div>


                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
