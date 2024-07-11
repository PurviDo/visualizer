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
        <input name="email" type="email" class="form-control" placeholder="Email">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      @error('email')
      <div class="text-danger">{{ $message }}</div>
      @enderror
      <div class="input-group mb-1">
        <input name="password" type="password" class="form-control" placeholder="Password">
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
        <div class="col-8">

        </div>
        <div class="col-4">
          <button type="submit" class="btn btn-secondary btn-block">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <p class="mb-1">
      <a href="{{ route('forget.password.get') }}">I forgot my password</a>
    </p>
  </div>
  <!-- /.login-card-body -->
</div>
@endsection