@extends('layouts.backend')

@section('title', __('Maintenance Plans'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    {{--    @vite('resources/js/pages/maintenance-plans.js')--}}
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
                        Create
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
                            Create
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
                    Create Maintenance Plan
                </h3>
                <div class="block-options">
                    <button type="submit" form="create" class="btn btn-alt-success btn-sm">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form id="create" action="{{ route('maintenance-plans.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Plan name<span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('plan_name') is-invalid @enderror"
                                   placeholder="..." name="plan_name"
                                   value="{{ old('maintenance_plan_name') }}">
                            @error('plan_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label">Equipment<span class="text-danger">*</span></label>
                            <select
                                class="js-select2 form-select form-control-alt @error('equipment_id') is-invalid @enderror"
                                name="equipment_id"
                                style="width: 100%;" data-placeholder="...">
                                <option></option>
                                @foreach($equipmentsCompact as $equipment)
                                    <option value="{{ $equipment->id }}"
                                            @if($equipment->id == old('equipment_id')) selected @endif>
                                        {{ $equipment->equipment_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('equipment_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label">Frequency<span class="text-danger">*</span></label>
                            <select class="form-select form-control-alt @error('frequency') is-invalid @enderror"
                                    name="frequency">
                                <option selected="">
                                    ...
                                </option>
                                @foreach(\App\Enums\MaintenancePlanFrequencyEnum::cases() as $frequency)
                                    <option value="{{ $frequency->value }}"
                                            @if($frequency->value == old('frequency')) selected @endif>
                                        {{ ucfirst(str_replace('_', ' ', $frequency->value)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('frequency')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea rows="10"
                                      class="form-control form-control-alt @error('description') is-invalid @enderror"
                                      placeholder="..."
                                      name="description">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
