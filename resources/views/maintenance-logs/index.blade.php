@extends('layouts.backend')

@section('title', __('Maintenance Logs'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite('resources/js/pages/maintenance-plans.js')
    <script type="module">
      One.helpersOnLoad(["jq-select2"]);
    </script>
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Maintenance Logs
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
                            <a class="link-fx" href="{{ route('maintenance-logs.index') }}">Maintenance Logs</a>
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
                <form action="{{ route('maintenance-logs.index') }}" method="get">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">Plan name</label>
                            <input type="text"
                                   class="form-control form-control-alt @error('plan_name') is-invalid @enderror"
                                   name="plan_name"
                                   value="{{ old('plan_name') ?? request('plan_name') }}"
                                   placeholder="Search by maintenance plan name">
                            @error('plan_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Equipment</label>
                            <input type="text" class="form-control form-control-alt" name="equipment_name"
                                   value="{{ old('equipment_name') ?? request('equipment_name') }}"
                                   placeholder="Search by equipment name">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Performed By</label>
                            <input type="text" class="form-control form-control-alt" name="performed_by"
                                   value="{{ old('performed_by') ?? request('performed_by') }}"
                                   placeholder="Search by performer name">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control form-control-alt" name="date"
                                   value="{{ old('date') ?? request('date') }}"
                                   placeholder="Search by date">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select form-control-alt" name="status">
                                <option value="">Choose one status...</option>
                                @foreach(\App\Enums\MaintenanceScheduleStatusEnum::cases() as $status)
                                    <option value="{{ $status->value }}"
                                            @if($status->value == old('status') || $status->value == request('status')) selected @endif>
                                        {{ strtoupper(str_replace('_', ' ', $status->value)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sort by</label>
                            <select class="form-select form-control-alt" name="sort_by">
                                <option value="id"
                                        @if(old('sort_by') === 'id' || request('sort_by') === 'id') selected @endif>
                                    Default
                                </option>
                                <option value="maintenance_plan_plan_name"
                                        @if(old('sort_by') === 'maintenance_plan_plan_name' || request('sort_by') === 'maintenance_plan_plan_name') selected @endif>
                                    Plan name
                                </option>
                                <option value="equipment_equipment_name"
                                        @if(old('sort_by') === 'equipment_equipment_name' || request('sort_by') === 'equipment_equipment_name') selected @endif>
                                    Equipment
                                </option>
                                <option value="maintenance_date"
                                        @if(old('sort_by') === 'maintenance_date' || request('sort_by') === 'maintenance_date') selected @endif>
                                    Date
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sort order</label>
                            <select class="form-select form-control-alt" name="sort_order">
                                <option value="asc"
                                        @if(old('sort_order') === 'asc' || request('sort_order') === 'asc') selected @endif>
                                    Ascending
                                </option>
                                <option value="desc"
                                        @if((!old('sort_order') && !request('sort_order')) || old('sort_order') === 'desc' || request('sort_order') === 'desc') selected @endif>
                                    Descending
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12 text-end mt-3">
                            <a href="{{ route('maintenance-logs.index') }}" class="btn btn-warning">
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
                    All Maintenance Logs
                </h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-vcenter fs-sm">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th>Equipment</th>
                        <th>Plan</th>
                        <th>Performer</th>
                        <th class="text-center">Date</th>
                        <th class="text-center" style="width: 80px;">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($maintenanceLogs as $i => $log)
                        <tr>
                            <td class="text-center">
                                {{ $maintenanceLogs->firstItem() + $i }}
                            </td>
                            <td class="fw-semibold">
                                <a href="{{ route('equipments.edit', $log->equipment_id) }}">
                                    {{ $log->equipment_equipment_name }}
                                </a>
                            </td>
                            <td class="fw-semibold">
                                <a href="{{ route('maintenance-schedules.show', $log->maintenance_schedule_id) }}">
                                    [S-{{ str_pad($log->maintenance_schedule_id, 4, '0', STR_PAD_LEFT) }}]
                                    {{ $log->maintenance_plan_plan_name }}
                                </a>
                            </td>
                            <td class="fw-semibold">
                                <a href="{{ route('users.show', $log->performer_id) }}">
                                    {{ $log->performer_name }}
                                </a>
                            </td>
                            <td class="text-center">
                                {{ $log->maintenance_date->format('Y/m/d') }}
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $log->outcome->getBadgeClass() }}">
                                    {{ strtoupper($log->outcome->value) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
