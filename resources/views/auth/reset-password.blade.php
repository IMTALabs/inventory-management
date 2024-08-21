@extends('layouts.simple')

@section('content')
    <div class="hero-static d-flex align-items-center">
        <div class="content">
            <div class="row justify-content-center push">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="block block-rounded mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Reset Password</h3>
                            <div class="block-options">
                                <a class="btn-block-option" href="{{ route('login') }}" data-bs-toggle="tooltip"
                                   data-bs-placement="left" title="Sign In">
                                    <i class="fa fa-sign-in-alt"></i>
                                </a>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                                <h1 class="h2 mb-1">{{ config('app.name') }}</h1>
                                <p class="fw-medium text-muted">
                                    Please enter your new password to continue with your account.
                                </p>
                                <form class="js-validation-signin" action="{{ route('password.update') }}"
                                      method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ request()->route('token') }}">
                                    <input type="hidden" name="email" value="{{ request()->query('email') }}">
                                    <div class="py-3">
                                        <div class="mb-4">
                                            <input type="password" value="{{ old('password') }}"
                                                   class="form-control form-control-alt form-control-lg @error('password') is-invalid @enderror"
                                                   id="password" name="password" placeholder="Password">
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-4">
                                            <input type="password" value="{{ old('password_confirmation') }}"
                                                   class="form-control form-control-alt form-control-lg @error('password_confirmation') is-invalid @enderror"
                                                   id="password_confirmation" name="password_confirmation"
                                                   placeholder="Password Confirmation">
                                            @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-8">
                                            <button type="submit" class="btn w-100 btn-alt-primary">
                                                <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Reset Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <!-- END Sign In Form -->
                            </div>
                        </div>
                    </div>
                    <!-- END Sign In Block -->
                </div>
            </div>
            <div class="fs-sm text-muted text-center">
                <strong>{{ config('app.name') }}</strong> &copy; <span data-toggle="year-copy"></span>
            </div>
        </div>
    </div>
@endsection
