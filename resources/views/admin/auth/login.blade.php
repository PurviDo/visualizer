@extends('admin.auth.layouts.app')
@section('content')

<!-- /.login-logo -->
<div class="card">
  <div class="card-body login-card-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="{{ route('login.post') }}" method="POST">
      @csrf

      @session('message')
      <div class="alert alert-danger" role="alert">
        {{ $value }}
      </div>
      @endsession
      <div class="input-group mb-1">
        <input name="email" type="email" value="admin@example.com" class="form-control" placeholder="Email">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      @error('email')
      <div class="text-danger">{{ $message }}</div>
      @enderror
      <div class="input-group mb-3">
        <input name="password" type="password" class="form-control" value="123456" placeholder="Password">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      @error('password')
      <div class="text-danger">{{ $message }}</div>
      @enderror
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <p class="mt-3 mb-1 text-center">
      <a href="{{ route('forget.password.get') }}">Forgot Password??</a>
    </p>
  </div>
  <!-- /.login-card-body -->
</div>
@endsection