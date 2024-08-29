@extends('layouts.backend')

@section('title', __('Maintenance Plans'))

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">
                    {{ $maintenancePlan->plan_name }}
                </h1>
                <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                    Detail
                </h2>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Invent</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        <a class="link-fx" href="{{ route('maintenance-plans.index') }}">Maintenance Plans</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        {{ $maintenancePlan->plan_name }}
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
            <h3 class="block-title">
                Maintenance Plan
            </h3>
            <div class="block-options">
                <a href="{{ route('maintenance-plans.edit', ['maintenancePlan' => $maintenancePlan]) }}">
                    <button class="btn btn-alt-warning btn-sm">
                        <i class="fa fa-pen"></i> Edit
                    </button>
                </a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Plan name</label>
                    <input type="text"
                        class="form-control form-control-alt" disabled
                        placeholder="..." value="{{ $maintenancePlan->plan_name }}">
                </div>
                <div class="col-6">
                    <label class="form-label">Equipment</label>
                    <input type="text"
                        class="form-control form-control-alt" disabled
                        placeholder="..." value="{{ $maintenancePlan->equipment_equipment_name }}">
                </div>
                <div class="col-6">
                    <label class="form-label">Frequency</label>
                    <input type="text"
                        class="form-control form-control-alt" disabled
                        placeholder="..."
                        value="{{ strtoupper($maintenancePlan->frequency->value) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea rows="10"
                        class="form-control form-control-alt" disabled
                        placeholder="...">{{ $maintenancePlan->description }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection