@extends('layouts.backend')

@section('title', __('Work Orders'))

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
                        Detail
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
            @if($workOrder->status == \App\Enums\WorkOrderStatusEnum::PENDING)
                @if(Auth::user()->is_admin)
                    <form class="col-lg-6" method="post"
                          action="{{ route('work-orders.update-status', $workOrder) }}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="status"
                               value="{{ \App\Enums\WorkOrderStatusEnum::ACTIVE }}">
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
                @if(Auth::user()->is_staff)
                    <form class="col-lg-6" method="post"
                          action="{{ route('work-orders.update-status', $workOrder) }}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="status"
                               value="{{ \App\Enums\WorkOrderStatusEnum::CANCELLED }}">
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
            @endif
            @if($workOrder->status == \App\Enums\WorkOrderStatusEnum::ACTIVE)
                @if(Auth::user()->is_staff)
                    <form class="col-lg-6" method="post"
                          action="{{ route('maintenance-schedules.update-status', $workOrder) }}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="status"
                               value="{{ \App\Enums\WorkOrderStatusEnum::COMPLETED }}">
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
                    <form class="col-lg-6" method="post"
                          action="{{ route('maintenance-schedules.update-status', $workOrder) }}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="status"
                               value="{{ \App\Enums\WorkOrderStatusEnum::CANCELLED }}">
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
            @endif
        </div>
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title d-flex align-items-center">
                    Detail
                    <span class="ms-2 badge {{ $workOrder->status->getBadgeClass() }}">
                        {{ strtoupper($workOrder->status->value) }}
                    </span>
                </h3>
                @if($workOrder->status == \App\Enums\WorkOrderStatusEnum::PENDING)
                    <div class="block-options">
                        <a href="{{ route('work-orders.edit', $workOrder) }}">
                            <button type="submit" class="btn btn-alt-warning btn-sm">
                                <i class="fa fa-pen"></i> Edit
                            </button>
                        </a>
                    </div>
                @endif
            </div>
            <div class="block-content block-content-full">
                <div class="row g-4">
                    <div class="col-6">
                        <label class="form-label">User</label>
                        <input type="text" class="form-control form-control-alt" disabled
                               value="[U-{{ str_pad($workOrder->user->id, 4, '0', STR_PAD_LEFT) }}] {{ $workOrder->user->name }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Equipment</label>
                        <input type="text" class="form-control form-control-alt" disabled
                               value="[E-{{ str_pad($workOrder->equipment->id, 4, '0', STR_PAD_LEFT) }}] {{ $workOrder->equipment->equipment_name }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Due date</label>
                        <input type="text" class="form-control form-control-alt" disabled
                               value="{{ $workOrder->due_date?->format('Y-m-d') ?? 'Indefinite' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Note</label>
                        <textarea
                            class="form-control form-control-alt" disabled
                            placeholder="..." rows="5">{{ $workOrder->notes }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Equipment</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <table class="table table-striped table-borderless">
                            <tbody>
                            @foreach($workOrder->equipment->toArray() as $key => $value)
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

            <div class="col-xl-4">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">User</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <table class="table table-striped table-borderless">
                            <tbody>
                            @foreach($workOrder->user->toArray() as $key => $value)
                                <tr>
                                    <td class="w-25">
                                        {{ ucwords(str_replace('_', ' ', $key)) }}
                                    </td>
                                    @switch($key)
                                        @case('role')
                                            <td>
                                                <span class="badge text-uppercase {{ role_badge_class($value) }}">
                                                    {{ $value }}
                                                </span>
                                            </td>
                                            @break
                                        @default
                                            <td class="text-break">
                                                {{ $value }}
                                            </td>
                                    @endswitch
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
