@extends('layouts.backend')

@section('title', __('Create Warranty Request'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection


@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Warranty Requests
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Create
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Invent</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Create Warranty Request
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Create Equipment</h3>
                <div class="block-options">
                    <button type="submit" form="create" class="btn btn-alt-success btn-sm">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form id="create" action="{{ route('requests.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="equipment_id" class="form-label">Equipment<span
                                    class="text-danger">*</span></label>
                            <select
                                class="form-control js-select2 form-select form-control-alt"
                                name="equipment_id" id="equipment_id">
                                <option value="">Select Equipment</option>
                                @foreach($equipment as $item)
                                    <option
                                        value="{{ $item->id }}" {{ old('equipment_id') == $item->id ? 'selected' : '' }}>{{ $item->equipment_name }}</option>
                                @endforeach
                            </select>
                            @error('equipment_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="request_date" class="form-label">Request Date<span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control form-control-alt @error('request_date') is-invalid @enderror"
                                   name="request_date" id="request_date" value="{{ old('request_date') }}">
                            @error('request_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-4">
                            <label for="issue_description" class="form-label">Issue Description<span
                                    class="text-danger">*</span></label>
                            <textarea
                                class="form-control form-control-alt @error('issue_description') is-invalid @enderror"
                                name="issue_description"
                                id="issue_description">{{ old('issue_description') }}</textarea>
                            @error('issue_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite('resources/js/pages/maintenance-plans.js')
@endsection
