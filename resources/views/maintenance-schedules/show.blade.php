@extends('layouts.backend')

@section('title', __('Maintenance Schedules'))

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
                        Maintenance Schedules
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
                            <a class="link-fx" href="{{ route('maintenance-schedules.index') }}">Maintenance
                                Schedules</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Detail
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
        <div class="row">
            @if($maintenanceSchedule->status == \App\Enums\MaintenanceScheduleStatusEnum::PENDING)
                <form class="col-lg-6" method="post"
                      action="{{ route('maintenance-schedules.update-status', $maintenanceSchedule) }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="status"
                           value="{{ \App\Enums\MaintenanceScheduleStatusEnum::CONFIRMED }}">
                    <a class="block block-rounded block-link-shadow text-center">
                        <div class="block-content block-content-full">
                            <div class="fs-2 fw-semibold text-info">
                                <i class="fa fa-eye"></i>
                            </div>
                        </div>
                        <div class="block-content py-2 bg-body-light">
                            <button class="btn fw-medium fs-sm text-info mb-0">
                                Confirm
                            </button>
                        </div>
                    </a>
                </form>
            @endif
            @if($maintenanceSchedule->status == \App\Enums\MaintenanceScheduleStatusEnum::CONFIRMED)
                <form class="col-lg-6" method="post"
                      action="{{ route('maintenance-schedules.update-status', $maintenanceSchedule) }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="status"
                           value="{{ \App\Enums\MaintenanceScheduleStatusEnum::COMPLETED }}">
                    <a class="block block-rounded block-link-shadow text-center">
                        <div class="block-content block-content-full">
                            <div class="fs-2 fw-semibold text-success">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                        <div class="block-content py-2 bg-body-light">
                            <button class="btn fw-medium fs-sm text-success mb-0">
                                Complete
                            </button>
                        </div>
                    </a>
                </form>
            @endif
            @if(in_array($maintenanceSchedule->status, \App\Enums\MaintenanceScheduleStatusEnum::canBeCancelled()))
                <form class="col-lg-6" method="post"
                      action="{{ route('maintenance-schedules.update-status', $maintenanceSchedule) }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="status"
                           value="{{ \App\Enums\MaintenanceScheduleStatusEnum::CANCELLED }}">
                    <a class="block block-rounded block-link-shadow text-center">
                        <div class="block-content block-content-full">
                            <div class="fs-2 fw-semibold text-danger">
                                <i class="fa fa-times"></i>
                            </div>
                        </div>
                        <div class="block-content py-2 bg-body-light">
                            <button class="btn fw-medium fs-sm text-danger mb-0">
                                Cancel
                            </button>
                        </div>
                    </a>
                </form>
            @endif
        </div>
        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title d-flex align-items-center">
                    Detail Maintenance Schedule
                    <span class="ms-2 badge {{ $maintenanceSchedule->status->getBadgeClass() }}">
                        {{ strtoupper($maintenanceSchedule->status->value) }}
                    </span>
                </h3>
                @if(
                    $maintenanceSchedule->status == \App\Enums\MaintenanceScheduleStatusEnum::PENDING
                    && Auth::user()->can('update', $maintenanceSchedule)
                )
                    <div class="block-options">
                        <a href="{{ route('maintenance-schedules.edit', $maintenanceSchedule) }}"
                           class="btn btn-alt-warning btn-sm">
                            <i class="fa fa-pen"></i> Edit
                        </a>
                    </div>
                @endif
            </div>
            <div class="block-content block-content-full">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Plan<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-alt"
                               value="[{{ str_pad($maintenanceSchedule->maintenancePlan->id, 4, '0', STR_PAD_LEFT) }}] {{ $maintenanceSchedule->maintenancePlan->plan_name }}"
                               disabled>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Scheduled Date<span class="text-danger">*</span></label>
                        <input type="date" disabled
                               class="form-control form-control-alt"
                               value="{{ $maintenanceSchedule->scheduled_date }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Performed By<span class="text-danger">*</span></label>
                        <input type="text" disabled
                               class="form-control form-control-alt"
                               value="[{{ str_pad($maintenanceSchedule->performer->id, 4, '0', STR_PAD_LEFT) }}] {{ $maintenanceSchedule->performer->name }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Remarks</label>
                        <textarea
                            class="form-control form-control-alt disabled"
                            name="remarks" placeholder="..."
                            rows="5">{{ $maintenanceSchedule->remarks }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Equipment
                </h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <th colspan="2">Detail</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($equipment->toArray() as $key => $value)
                        <tr>
                            <td class="w-25">
                                {{ ucwords(str_replace('_', ' ', $key)) }}
                            </td>
                            <td>
                                {{ $value }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
