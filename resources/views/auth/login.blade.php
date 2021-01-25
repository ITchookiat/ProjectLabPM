@extends('layouts.app')
@section('content')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <!-- <div align="right">
                <img class="img-responsive" src="{{ asset('dist/img/test2.gif') }}" alt="User Image" style = "width: 100%">
            </div> -->
                <div class="text-center mb-4">
                    <img class="mb-4" src="{{ asset('dist/img/leasingLogo3.png') }}" alt="" width="90" height="90" style="border-radius:  10px;">
                    <h1 class="h3 mb-3 font-weight-normal">CHOOKIAT PLOAN-MICRO</h1>
                    <p><code>ชูเกียรติลิสซิ่ง กู้ง่าย คนใต้ด้วยกัน</code></p>
                </div>
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Sign in to start your session</p>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <input id="username" type="text" name="username" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' || $errors->has('username') ? ' is-invalid' : '' }}" value="{{ old('username') }}" placeholder="username" required autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user-lock"></span>
                                    </div>
                                </div>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-group mb-3">
                                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a href="http://192.168.200.9/Projectleasing/public" class="btn btn-danger btn-block" >Home</a>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                            </div>
                            <p class="mt-5 mb-3 text-muted text-center">© Programmer Chookiat PN</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
