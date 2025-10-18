@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-password-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Reset Your Password</h1>
                            <p>Enter your new password below to reset your account password.</p>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}" class="user">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <input type="email" name="email" 
                                       class="form-control form-control-user @error('email') is-invalid @enderror" 
                                       placeholder="Email Address" 
                                       value="{{ $email ?? old('email') }}" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" name="password" 
                                           class="form-control form-control-user @error('password') is-invalid @enderror" 
                                           placeholder="New Password" required>
                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="password_confirmation" 
                                           class="form-control form-control-user" 
                                           placeholder="Confirm Password" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Reset Password
                            </button>
                        </form>

                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('login') }}">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
