@extends('layouts.formular')
@section('content')
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="index.html" class="logo d-flex align-items-center w-auto">
                                <img src="assets/img/logo.png" alt="">
                                <span class="d-none d-lg-block">NiceAdmin</span>
                            </a>
                        </div><!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Connectez-vous à votre compte</h5>
                                    <p class="text-center small">Entrez votre e-mail & votre mot de passe pour vous connecter</p>
                                </div>

                                <form class="row g-3 needs-validation" novalidate action="{{ route('login') }}" method="post">
                                    @csrf
                                    @if(Session::has('fail'))
                                        <span class="text-danger">
                                            {{ Session::get('fail') }}
                                        </span>
                                    @endif
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Nom d'utilisateur</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="text" name="username"
                                                   value="{{ old('username') }}"
                                                   class="form-control @error('username') is-invalid @enderror" id="yourUsername">
                                            @error('username')
                                            <div class="invalid-feedback">{{ $message }}!</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password"
                                               value="{{ old('password') }}"
                                               class="form-control @error('password') is-invalid @enderror" id="yourPassword">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}!</div>
                                        @enderror
                                    </div>


                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Souviens-toi de moi</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Se connecter</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Vous n'avez pas de compte ? <a href="{{ route('register') }}">Créer un compte</a></p>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="credits">
                            <!-- All the links in the footer should remain intact. -->
                            <!-- You can delete the links only if you purchased the pro version. -->
                            <!-- Licensing information: https://bootstrapmade.com/license/ -->
                            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
@endsection
