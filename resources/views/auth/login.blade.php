
@extends('frontend.layouts.app_plain')

@section('title','Login');

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh">
        <div class="col-md-6">
            <div class="card auth-form">

            <div class="card-body">


                <h3 class="text-center">Login</h3>
                <p class="text-center text-muted">Fill Form To Login</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf


                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone"  class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">


                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="email">Password</label>
                        <input type="password" id="email" name="password" class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>


                    <button class="btn btn-primary btn-block my-5 btn-theme">LOGIN</button>

                        <div class="d-flex justify-content-between form-link">
                            <a href="{{route('register')}}">Register Now</a>

                            @if (Route::has('password.request'))
                                <a class="" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>

                </form>
            </div>
        </div></div>

    </div>




</div>
@endsection
