@extends('layouts.backend')

@section('title', __('Maintenance Schedules'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    {{--    @vite('resources/js/pages/maintenance-plans.js')--}}
    <script type="module">
      One.helpersOnLoad(["jq-select2"]);
    </script>
@endsection

@php
    /**
     * @var \App\Models\MaintenanceSchedule[] $maintenanceSchedules
     */
@endphp

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
                        List
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
                            List
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
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <form action="{{ route('maintenance-schedules.index') }}" method="get">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">Plan name</label>
                            <input type="text"
                                   class="form-control form-control-alt @error('plan_name') is-invalid @enderror"
                                   name="plan_name" value="{{ request('plan_name') }}"
                                   placeholder="Search by name">
                            @error('plan_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Scheduled Date From</label>
                            <input type="date"
                                   class="form-control form-control-alt @error('scheduled_date_from') is-invalid @enderror"
                                   name="scheduled_date_from"
                                   value="{{ request('scheduled_date_from') }}">
                            @error('scheduled_date_from')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Scheduled Date To</label>
                            <input type="date"
                                   class="form-control form-control-alt @error('scheduled_date_to') is-invalid @enderror"
                                   name="scheduled_date_to"
                                   value="{{ request('scheduled_date_to') }}">
                            @error('scheduled_date_to')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Maintainer</label>
                            <select
                                class="js-select2 form-select form-control-alt @error('performed_by') is-invalid @enderror"
                                name="performed_by"
                                style="width: 100%;" data-placeholder="Choose one maintainer...">
                                <option></option>
                                @foreach($maintainersCompact as $maintainer)
                                    <option value="{{ $maintainer->id }}"
                                            @if($maintainer->id == request('performed_by')) selected @endif>
                                        [{{ str_pad($maintainer->id, 4, '0', STR_PAD_LEFT) }}] {{ $maintainer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('performed_by')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select
                                class="js-select2 form-select form-control-alt @error('status') is-invalid @enderror"
                                name="status"
                                style="width: 100%;" data-placeholder="Choose one status...">
                                <option></option>
                                @foreach(\App\Enums\MaintenanceScheduleStatusEnum::cases() as $status)
                                    <option value="{{ $status->value }}"
                                            @if($status->value == request('status')) selected @endif>
                                        {{ strtoupper($status->value) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 text-end">
                            <a href="{{ route('maintenance-schedules.index') }}" class="btn btn-warning">
                                <i class="fa fa-undo"></i> Reset
                            </a>
                            <button type="submit" class="btn btn-dark">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    All Maintenance Schedules
                </h3>
                <div class="block-options fs-sm fw-semibold">
                    <i class="fa fa-fw fa-wrench text-success"></i> In Progress
                    <span class="mx-2 text-muted">|</span>
                    <i class="fa fa-fw fa-wrench text-warning"></i> Upcoming
                </div>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-vcenter fs-sm">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th>Plan</th>
                        <th class="text-center" style="width: 200px;">Scheduled Date</th>
                        <th class="text-center">Maintainer</th>
                        <th class="text-center" style="width: 80px;">Status</th>
                        <th class="text-center" style="width: 80px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($maintenanceSchedules as $i => $schedule)
                        <tr>
                            <td class="text-center">
                                {{ $maintenanceSchedules->firstItem() + $i }}
                            </td>
                            <td class="fw-bold">
                                <a href="{{ route('maintenance-plans.show', ['maintenancePlan' => $schedule->maintenancePlan]) }}">
                                    {{ $schedule->maintenancePlan ->plan_name }}
                                </a>
                            </td>
                            <td class="text-center fw-semibold">
                                @if($schedule->scheduled_date < now())
                                    <i class="fa fa-fw fa-wrench text-success"></i>
                                @elseif($schedule->scheduled_date < now()->addDays(7))
                                    <i class="fa fa-fw fa-wrench text-warning"></i>
                                @endif
                                {{ $schedule->scheduled_date }}
                            </td>
                            <td class="text-center fw-bold">
                                <a href="{{ route('users.show', ['user' => $schedule->performer]) }}">
                                    {{ $schedule->performer->name }}
                                </a>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $schedule->status->getBadgeClass() }}">
                                    {{ strtoupper($schedule->status->value) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('maintenance-schedules.show', ['maintenanceSchedule' => $schedule]) }}">
                                        <button type="button" class="btn btn-sm btn-alt-info">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </button>
                                    </a>
                                    @if($schedule->status == \App\Enums\MaintenanceScheduleStatusEnum::PENDING)
                                        <a href="{{ route('maintenance-schedules.edit', ['maintenanceSchedule' => $schedule]) }}">
                                            <button type="button" class="btn btn-sm btn-alt-warning">
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </button>
                                        </a>
                                        <form class="form-delete"
                                              action="{{ route('maintenance-schedules.destroy', ['maintenanceSchedule' => $schedule]) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-alt-danger">
                                                <i class="fa fa-fw fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $maintenanceSchedules->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
@endsection
