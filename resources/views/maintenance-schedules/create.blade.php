@extends('layouts.backend')

@section('title', __('Maintenance Schedules'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
      const maintenancePlans = @json($maintenancePlansCompact);
      const badgeClasses = @json(\App\Enums\MaintenancePlanFrequencyEnum::frequencyBadgeClasses());
      jQuery("#plan").on("select2:select", function (e) {
        const data = e.params.data;
        const index = Number(data.id);
        const plan = maintenancePlans.find(((_, idx) => idx === index));
        let frequency = plan.frequency;
        const badgeClass = badgeClasses[frequency];
        frequency = frequency.replace(/_/g, " ").toUpperCase();
        jQuery("#frequency").html(`<span class="badge ${ badgeClass }">${ frequency }</span>`);
      });
      jQuery("#auto_schedule").on("change", function () {
        if (jQuery(this).is(":checked")) {
          jQuery("#scheduled_to").prop("disabled", false);
        } else {
          jQuery("#scheduled_to").prop("disabled", true);
        }
      });
    </script>
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
                        Create
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
                    Create Maintenance Schedule
                </h3>
                <div class="block-options">
                    <button type="submit" form="create" class="btn btn-alt-success btn-sm">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form id="create" action="{{ route('maintenance-schedules.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Plan<span class="text-danger">*</span></label>
                            <select id="plan"
                                    class="js-select2 form-select form-control-alt @error('maintenance_plan_id') is-invalid @enderror"
                                    name="maintenance_plan_id"
                                    style="width: 100%;" data-placeholder="...">
                                <option></option>
                                @foreach($maintenancePlansCompact as $plan)
                                    <option value="{{ $plan->id }}"
                                            @if($plan->id == old('maintenance_plan_id')) selected @endif>
                                        [{{ str_pad($plan->id, 4, '0', STR_PAD_LEFT) }}] {{ $plan->plan_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('maintenance_plan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label">Scheduled Date<span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control form-control-alt @error('scheduled_date') is-invalid @enderror"
                                   name="scheduled_date"
                                   value="{{ old('scheduled_date') }}">
                            @error('scheduled_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label">Performed By<span class="text-danger">*</span></label>
                            <select
                                class="js-select2 form-select form-control-alt @error('performed_by') is-invalid @enderror"
                                name="performed_by"
                                style="width: 100%;" data-placeholder="...">
                                <option></option>
                                @foreach($maintainersCompact as $user)
                                    <option value="{{ $user->id }}"
                                            @if($user->id == old('performed_by')) selected @endif>
                                        [{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}] {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('performed_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label class="form-label">Frequency</label>
                            <div id="frequency">
                                <span class="badge bg-secondary text-white">
                                    Please select a plan
                                </span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Auto Schedule</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" value="1" id="auto_schedule"
                                       name="auto_schedule" @if(old('auto_schedule') == 1) checked @endif>
                                <label class="form-check-label" for="auto_schedule">
                                    Auto create schedule
                                </label>
                            </div>
                            @error('auto_schedule')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label class="form-label" for="scheduled_to">Scheduled To</label>
                            <input type="date" id="scheduled_to" disabled
                                   class="form-control form-control-alt @error('scheduled_to') is-invalid @enderror"
                                   name="scheduled_to"
                                   value="{{ old('scheduled_to') }}">
                            @error('scheduled_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <textarea
                                class="form-control form-control-alt @error('remarks') is-invalid @enderror"
                                name="remarks" placeholder="..."
                                rows="5">{{ old('remarks') }}</textarea>
                            @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
