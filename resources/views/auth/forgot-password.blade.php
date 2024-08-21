@extends('layouts.simple')

@section('content')
    <!-- Page Content -->
    <div class="hero-static d-flex align-items-center">
        <div class="content">
            <div class="row justify-content-center push">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <!-- Reminder Block -->
                    <div class="block block-rounded mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                Forgot Password
                            </h3>
                            <div class="block-options">
                                <a class="btn-block-option" href="{{ route('login') }}" data-bs-toggle="tooltip"
                                   data-bs-placement="left" title="Sign In">
                                    <i class="fa fa-sign-in-alt"></i>
                                </a>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                                @session('status')
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <p class="mb-0">
                                        {{ session('status') }}
                                    </p>
                                </div>
                                @endsession
                                <h1 class="h2 mb-1">{{ config('app.name') }}</h1>
                                <p class="fw-medium text-muted">
                                    Please provide your account’s email and we will send you your password.
                                </p>

                                <!-- Reminder Form -->
                                <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/op_auth_reminder.min.js which was auto compiled from _js/pages/op_auth_reminder.js) -->
                                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                <form class="js-validation-reminder mt-4" action="{{ route('password.email') }}"
                                      method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <input type="text"
                                               class="form-control form-control-lg form-control-alt @error('email') is-invalid @enderror"
                                               id="reminder-credential" name="email"
                                               placeholder="Email">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn w-100 btn-alt-primary">
                                                <i class="fa fa-fw fa-envelope me-1 opacity-50"></i> Send Mail
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <!-- END Reminder Form -->
                            </div>
                        </div>
                    </div>
                    <!-- END Reminder Block -->
                </div>
            </div>
            <div class="fs-sm text-muted text-center">
                <strong>{{ config('app.name') }}</strong> &copy; <span data-toggle="year-copy"></span>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
