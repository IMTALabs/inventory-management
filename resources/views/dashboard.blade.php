@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Dashboard
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Welcome {{ Auth::user()->name }}, everything looks great.
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Invent</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Dashboard
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-sm-6 col-xxl-3">
                <!-- Pending Orders -->
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div
                        class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ $pendingWorkOrdersCount }}</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Pending Orders</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="si si-folder-alt fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                           href="{{ route('work-orders.index', ['status' => \App\Enums\WorkOrderStatusEnum::PENDING->value]) }}">
                            <span>View all orders</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
                <!-- END Pending Orders -->
            </div>
            <div class="col-sm-6 col-xxl-3">
                <!-- Messages -->
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div
                        class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ $incomingMaintenanceSchedulesCount }}</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">
                                Incoming Maintenance Schedule
                            </dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="si si-wrench fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                           href="{{ route('maintenance-schedules.index') }}">
                            <span>View all maintenance schedules</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
                <!-- END Messages -->
            </div>
            <div class="col-sm-6 col-xxl-3">
                <!-- Conversion Rate -->
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div
                        class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ $equipmentCount }}</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Equipment</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="si si-screen-desktop fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                           href="{{ route('equipments.index') }}">
                            <span>View all equipment</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
                <!-- END Conversion Rate-->
            </div>
            <div class="col-sm-6 col-xxl-3">
                <!-- New Customers -->
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div
                        class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ $usersCount }}</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Active Users</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="si si-user fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                           href="{{ route('users.index') }}">
                            <span>View all users</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
                <!-- END New Customers -->
            </div>
        </div>

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Pending Work Orders</h3>
                <div class="block-options space-x-1">
                    <a href="{{ route('work-orders.index') }}">
                        <button type="button" class="btn btn-alt-primary btn-sm">
                            <i class="fa fa-arrow-alt-circle-right"></i> View All Work Orders
                        </button>
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">#</th>
                            <th>Equipment</th>
                            <th>User</th>
                            <th class="text-center" style="width: 80px;">Status</th>
                            <th class="text-center" style="width: 120px;">Due date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pendingWorkOrders as $i => $order)
                            <tr>
                                <td class="text-center">
                                    {{ $i + 1 }}
                                </td>
                                <td class="fw-semibold">
                                    <a href="{{ route('equipments.edit', ['equipment' => $order->equipment]) }}">
                                        [E-{{ str_pad($order->equipment->id, 4, '0', STR_PAD_LEFT) }}]
                                        {{ $order->equipment->equipment_name }}
                                    </a>
                                </td>
                                <td class="fw-semibold">
                                    <a href="{{ route('users.show', ['user' => $order->user]) }}">
                                        [U-{{ str_pad($order->user->id, 4, '0', STR_PAD_LEFT) }}]
                                        {{ $order->user->name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $order->status->getBadgeClass() }}">
                                        {{ strtoupper($order->status->value) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{ $order->due_date?->format('Y-m-d') }}
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('work-orders.show', ['workOrder' => $order]) }}">
                                            <button type="button" class="btn btn-sm btn-alt-info">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Incoming Maintenance Schedules</h3>
                <div class="block-options space-x-1">
                    <a href="{{ route('maintenance-schedules.index') }}">
                        <button type="button" class="btn btn-alt-primary btn-sm">
                            <i class="fa fa-arrow-alt-circle-right"></i> View All Maintenance Schedules
                        </button>
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter">
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
                        @foreach ($incomingMaintenanceSchedules as $i => $schedule)
                            <tr>
                                <td class="text-center">
                                    {{ $i + 1 }}
                                </td>
                                <td class="fw-semibold">
                                    <a href="{{ route('maintenance-plans.show', ['maintenancePlan' => $schedule->maintenancePlan]) }}">
                                        [P-{{ str_pad($schedule->maintenancePlan->id, 4, '0', STR_PAD_LEFT) }}]
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
                                <td class="text-center fw-semibold">
                                    <a href="{{ route('users.show', ['user' => $schedule->performer]) }}">
                                        [U-{{ str_pad($schedule->performer->id, 4, '0', STR_PAD_LEFT) }}]
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
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- END Recent Orders Table -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
