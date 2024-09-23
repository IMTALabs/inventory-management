@extends('layouts.backend')

@section('title', 'Metrics')

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    @vite('resources/js/pages/metrics.js')
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Metrics
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Manage
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Invent</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('metrics.index') }}">Metrics</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Manage
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        @include('common.alert')
        <form class="block block-rounded" action="{{ route('metrics.store') }}" method="POST">
            <div class="block-header block-header-default">
                <h3 class="block-title">All Metrics</h3>
                <div class="block-options">
                    <button type="submit" class="btn btn-alt-success btn-sm">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                @csrf
                <div class="list-metrics row g-3 mb-3">
                    @foreach($metrics as $metric)
                        <div class="col-7">
                            <input type="text" class="form-control form-control-alt" name="name[]" placeholder="Name"
                                   value="{{ $metric->name }}">
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-alt" name="unit[]" placeholder="Unit"
                                   value="{{ $metric->unit }}">
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn-remove-metric btn w-100 text-danger">
                                <i class="fa fa-xl fa-circle-xmark"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="button" class="btn-add-metric btn btn-alt-primary btn-sm">
                            <i class="fa fa-plus"></i> Add Metric
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- END Page Content -->
@endsection
