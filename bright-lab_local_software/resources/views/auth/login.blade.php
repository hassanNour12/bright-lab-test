@extends('layouts.fullLayoutMaster')
{{-- title --}}

@section('title','Login')

{{-- page scripts --}}

@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<!-- login page start -->
<section id="auth-login" class="row flexbox-container">
  <div class="col-xl-8 col-11">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <!-- left section-login -->
        <div class="col-md-6 col-12 px-0">
          <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            <div class="card-header text-center pb-1" style="justify-content: space-around;">
              <div class="card-title text-center">
                <h4 class="text-center mb-2">Welcome Back</h4>
              </div>
            </div>
            <div class="card-body" style="display: contents;">
              
              <div class="divider">
                <div class="divider-text text-uppercase text-muted">
                  <small>Login With Email</small>
                </div>
              </div>
              {{-- form  --}}
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group mb-50">
                  <label class="text-bold-600" for="email">Email address</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus placeholder="Email address">
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="text-bold-600" for="password">Password</label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password" placeholder="Password">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary glow w-100 position-relative">Login
                  <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                </button>
              </form>
              <hr>
            </div>
          </div>
        </div>
        <!-- right section image -->
        <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
          <img class="img-fluid" src="{{asset('images/pages/login.png')}}" alt="branding logo">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- login page ends -->
@endsection
