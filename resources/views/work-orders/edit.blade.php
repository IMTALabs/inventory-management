@extends('layouts.backend')

@section('title', __('Work Orders'))

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
                        Work Orders
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Edit
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Invent</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('work-orders.index') }}">Work Orders</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Edit
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

        <form class="block block-rounded" action="{{ route('work-orders.update', $workOrder) }}" method="post">
            @method('PUT')
            @csrf
            <div class="block-header block-header-default">
                <h3 class="block-title">Edit Work Order</h3>
                <div class="block-options">
                    <button type="submit" class="btn btn-alt-success btn-sm">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="row g-4">
                    <div class="col-6">
                        <label class="form-label">User<span class="text-danger">*</span></label>
                        <select
                            class="js-select2 form-select form-control-alt @error('user_id') is-invalid @enderror"
                            name="user_id"
                            style="width: 100%;" data-placeholder="...">
                            <option></option>
                            @foreach($usersCompact as $user)
                                <option value="{{ $user->id }}"
                                        @if($user->id == old('user_id') || $user->id == $workOrder->user_id) selected @endif>
                                    [U-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}] {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
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
                                        @if($equipment->id == old('equipment_id') || $equipment->id == $workOrder->equipment_id) selected @endif>
                                    [E-{{ str_pad($equipment->id, 4, '0', STR_PAD_LEFT) }}]
                                    {{ $equipment->equipment_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('equipment_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Due date</label>
                        <input type="date"
                               class="form-control form-control-alt @error('due_date') is-invalid @enderror"
                               name="due_date" min="{{ date('Y-m-d') }}"
                               value="{{ old('due_date') ?? $workOrder->due_date?->format('Y-m-d') }}">
                        @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Note</label>
                        <textarea
                            class="form-control form-control-alt @error('notes') is-invalid @enderror"
                            name="notes" placeholder="..."
                            rows="5">{{ old('notes') ?? $workOrder->notes }}</textarea>
                        @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- END Page Content -->
@endsection
