@extends('layouts.app')
@section('title', 'Informations de professeur')

@section('content')

    <div class="pagetitle">
        <h1>Informations de professeur</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('teachers') }}">Professeurs</a></li>
                <li class="breadcrumb-item">Professeur</li>
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
                                <img class="image" src="{{ asset($teacher->img_path? 'storage/' .  $teacher->img_path : 'storage/images/t_placeholder.jpeg') }}" style="width: 300px">
                            </div>
                            <div class="col-md-auto">
                                <div class="mt-3">
                                    <p><span
                                            class="text-secondary">Nom : </span>{{ $teacher->first_name . " ". $teacher->last_name  }}
                                    </p>
                                    <p><span class="text-secondary">NNI : </span>{{ $teacher->nni }}</p>
                                    <p><span class="text-secondary">Date de naissance : </span>
                                        @php
                                            $dateOfBirthArray = explode('-', $teacher->date_of_birth);
                                            $dayOfWeek = date('w', strtotime($teacher->date_of_birth));
                                            $day = $dateOfBirthArray[2];
                                            $month = $dateOfBirthArray[1];
                                            $year = $dateOfBirthArray[0];

                                            $daysOfMonth = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
                                            $monthsOfYear = array(
                                                "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
                                                "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
                                            );

                                            echo $daysOfMonth[$dayOfWeek - 1] . ' ' . $day . ' ' . $monthsOfYear[$month - 1]. ' ' . $year;
                                        @endphp
                                    </p>
{{--                                    <p><span class="text-secondary">Classe : </span>{{ $student->name }}</p>--}}
{{--                                    <p><span class="text-secondary">Sexe : </span>{{ $student->sex }}</p>--}}
                                </div>
                            </div>

                        </div>


                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
