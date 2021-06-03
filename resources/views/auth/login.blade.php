@extends('layouts.auth')
@section('title', 'Login Dashboard')
@section('content')
<div class="card shadow card-primary">
  <div class="card-header"><h4>Login</h4></div>
  <div class="card-body">
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus autocomplete="false">
        @error('email')
        <span class="invalid-feedback">
          <strong>{{$message}}</strong>
        </span>
        @enderror
      </div>
    <div class="form-group">
      <label for="password" class="control-label">Password</label>
      <input id="password" type="password" class="form-control" name="password" tabindex="2" autocomplete="false" required>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{$message}}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="custom-control-label" for="remember">
            {{ __('Remember Me') }}
        </label>
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
          Login
        </button>
      </div>
      <div class="d-block">
      <div class="float-right">
          @if (Route::has('password.request'))
          <a class="text-small" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
          </a>
        @endif
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
