@extends('admin.auth.layouts.app')
@section('content')
    <div class="card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      <form action="{{ route('forget.password.post')}}" method="post">
      @csrf

      @session('message')
          <div class="alert alert-secondary" role="alert"> 
              {{ $value }}
          </div>
      @endsession
        <div class="input-group mb-3">
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
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1 text-center">
        <a href="{{ url('/') }}">Login</a>
      </p>
    </div>
@endsection
