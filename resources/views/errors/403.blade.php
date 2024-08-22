@extends('layouts.simple')

@section('title', '403 Forbidden')

@section('content')
    <!-- Page Content -->
    <div class="hero">
        <div class="hero-inner text-center">
            <div class="bg-body-extra-light">
                <div class="content content-full overflow-hidden">
                    <div class="py-4">
                        <!-- Error Header -->
                        <h1 class="display-1 fw-bolder text-flat">
                            403
                        </h1>
                        <h2 class="h4 fw-normal text-muted mb-5">
                            {{ $exception->getMessage() ?? 'Forbidden' }}
                        </h2>
                        <!-- END Error Header -->

                        <a href="{{ route('dashboard') }}">
                            <button class="btn btn-alt-primary">
                                <i class="fa fa-arrow-left"></i> Go Back to Dashboard
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="content content-full text-muted fs-sm fw-medium">
                <!-- Error Footer -->
                <p class="mb-1">
                    Would you like to let us know about it?
                </p>
                <a class="link-fx" href="javascript:void(0)">Report it</a>
                <!-- END Error Footer -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
