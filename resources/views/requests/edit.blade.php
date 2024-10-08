@extends('layouts.backend')

@section('title', __('Warranty Requests'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="module">
        One.helpersOnLoad(["jq-select2"]);
    </script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Warranty Request
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Update
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Invent</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="{{ route('requests.index') }}">Warranty Request</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('requests.index') }}">Warranty Request</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Update
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
        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title d-flex align-items-center">
                    Detail Request Warranty
                    <span class="ms-2 badge {{ $requestWarranty->status->getBadgeClass() }}">
                        {{ strtoupper($requestWarranty->status->value) }}
                    </span>
                </h3>
                @if($requestWarranty->status == \App\Enums\MaintenanceScheduleStatusEnum::PENDING)
                    <div class="block-options">
                        <div class="block-options">
                            <button type="submit" form="create" class="btn btn-alt-warning btn-sm">
                                <i class="fa fa-pen"></i> Edit
                            </button>
                        </div>
                    </div>
                @endif
            </div>
            <div class="block-content block-content-full">
                <form id="create" action="{{ route('requests.update', ['request' => $requestWarranty]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">Equiment Name<span class="text-danger">*</span></label>
                            <select
                                class="form-control js-select2 form-select form-control-alt @error('equipment_id') is-invalid @enderror"
                                name="equipment_id" id="equipment_id">
                                <option value="">Select Equipment</option>
                                @foreach($equipment as $item)
                                    <option
                                        value="{{ $item->id }}" {{ $requestWarranty->equipment_id == $item->id ? 'selected' : '' }}>{{ $item->equipment_name }}</option>
                                @endforeach
                            </select>
                            @error('equipment_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label">Request Date<span class="text-danger">*</span></label>
                            <input type="date"
                                   name="request_date"
                                   class="form-control form-control-alt @error('request_date') is-invalid @enderror"
                                   value="{{ $requestWarranty->request_date->format('Y-m-d') }}">
                            @error('request_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Issue Description</label>
                            <textarea
                                class="form-control form-control-alt disabled @error('issue_description') is-invalid @enderror"
                                name="issue_description" placeholder="..."
                                rows="5">{{ $requestWarranty->issue_description }}</textarea>
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
