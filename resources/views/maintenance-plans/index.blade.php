@extends('layouts.backend')

@section('title', __('Maintenance Plans'))

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
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Maintenance Plans
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
                            <a class="link-fx" href="{{ route('maintenance-plans.index') }}">Maintenance Plans</a>
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
                <form action="{{ route('maintenance-plans.index') }}" method="get">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">Plan name</label>
                            <input type="text" class="form-control form-control-alt" name="plan_name" value="{{ request('plan_name') }}"
                                   placeholder="Search by name">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Equipment</label>
                            <select class="js-select2 form-select form-control-alt" name="equipment_id"
                                    style="width: 100%;" data-placeholder="Choose one equipment...">
                                <option></option>
                                @foreach($equipmentsCompact as $equipment)
                                    <option value="{{ $equipment->id }}"
                                            @if($equipment->id == request('equipment_id')) selected @endif>
                                        {{ $equipment->equipment_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Frequency</label>
                            <select class="form-select form-control-alt" name="frequency">
                                <option value="">Choose one frequency...</option>
                                @foreach(\App\Enums\MaintenancePlanFrequencyEnum::cases() as $frequency)
                                    <option value="{{ $frequency->value }}"
                                            @if($frequency->value == request('frequency')) selected @endif>
                                        {{ strtoupper(str_replace('_', ' ', $frequency->value)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sort by</label>
                            <select class="form-select form-control-alt" name="sort_by">
                                <option value="id" @if(request('sort_by') === 'id') selected @endif>
                                    Default
                                </option>
                                <option value="plan_name" @if(request('sort_by') === 'plan_name') selected @endif>
                                    Plan name
                                </option>
                                <option value="equipment_equipment_name"
                                        @if(request('sort_by') === 'equipment_equipment_name') selected @endif>
                                    Equipment
                                </option>
                                <option value="frequency" @if(request('sort_by') === 'frequency') selected @endif>
                                    Frequency
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sort order</label>
                            <select class="form-select form-control-alt" name="sort_order">
                                <option value="asc" @if(request('sort_order') === 'asc') selected @endif>
                                    Ascending
                                </option>
                                <option value="desc"
                                        @if(!request('sort_order') || request('sort_order') === 'desc') selected @endif>
                                    Descending
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12 text-end">
                            <a href="{{ route('maintenance-plans.index') }}" class="btn btn-warning">
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
                    ALl Maintenance Plans
                </h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-vcenter fs-sm">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th>Name</th>
                        <th>Equipment</th>
                        <th class="text-center" style="width: 80px;">Frequency</th>
                        <th class="text-center" style="width: 80px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($maintenancePlans as $i => $plan)
                        <tr>
                            <td class="text-center">
                                {{ $maintenancePlans->firstItem() + $i }}
                            </td>
                            <td class="fw-semibold">
                                <a href="{{ route('maintenance-plans.show', ['maintenancePlan' => $plan]) }}">
                                    {{ $plan->plan_name }}
                                </a>
                            </td>
                            <td>
                                {{ $plan->equipment_equipment_name }}
                            </td>
                            <td class="text-center">
                                <span
                                    class="badge {{ maintenance_plan_frequency_badge_class($plan->frequency) }} text-white text-uppercase">
                                    {{ str_replace('_', ' ', $plan->frequency->value) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('maintenance-plans.edit', ['maintenancePlan' => $plan]) }}">
                                        <button type="button" class="btn btn-sm btn-alt-warning">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </button>
                                    </a>
                                    <form class="form-delete"
                                          action="{{ route('maintenance-plans.destroy', ['maintenancePlan' => $plan]) }}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-alt-danger">
                                            <i class="fa fa-fw fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $maintenancePlans->onEachSide(5)->links() }}
            </div>
        </div>
    </div>
@endsection
