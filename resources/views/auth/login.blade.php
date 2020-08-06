@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <br>
          <!-- <div align="right">
            <img class="img-responsive" src="{{ asset('dist/img/test2.gif') }}" alt="User Image" style = "width: 100%">
          </div> -->
            <div class="card">
                <div class="card-header">{{ __('กรุณากรอกชื่อและรหัส เพื่อเข้าใช้งาน') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail or Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" placeholder="username" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' || $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

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
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <!-- <div class="form-group row">
                            <label for="DB_type" class="col-md-4 col-form-label text-md-right">{{ __('Database') }}</label>

                            <div class="col-md-6">
                                <select name="DB_type" class="form-control" required>
                                    <option selected disabled value="">เลือกฐานข้อมูล</option>
                                    <option value="1" > ระบบ ลิสซิ่ง</option>
                                    <option value="2" > ระบบ รถบ้าน</option>
                                </select>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
