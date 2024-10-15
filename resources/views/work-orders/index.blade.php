@extends('layouts.backend')

@section('title', __('Work Orders'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/pages/work-orders.js'])
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
                        List
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
                <form action="{{ route('work-orders.index') }}" method="get">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Equipment</label>
                            <select
                                class="js-select2 form-select form-control-alt @error('equipment_id') is-invalid @enderror"
                                name="equipment_id"
                                style="width: 100%;" data-placeholder="...">
                                <option></option>
                                @foreach($equipmentsCompact as $equipment)
                                    <option value="{{ $equipment->id }}"
                                            @if($equipment->id == request('equipment_id')) selected @endif>
                                        [E-{{ str_pad($equipment->id, 4, '0', STR_PAD_LEFT) }}]
                                        {{ $equipment->equipment_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('equipment_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">User</label>
                            <select
                                class="js-select2 form-select form-control-alt @error('user_id') is-invalid @enderror"
                                name="user_id"
                                style="width: 100%;" data-placeholder="...">
                                <option></option>
                                @foreach($usersCompact as $user)
                                    <option value="{{ $user->id }}"
                                            @if($user->id == request('user_id')) selected @endif>
                                        [U-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}] {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select
                                class="form-select form-control-alt @error('status') is-invalid @enderror"
                                name="status"
                                style="width: 100%;" data-placeholder="...">
                                <option value="">...</option>
                                @foreach(\App\Enums\WorkOrderStatusEnum::cases() as $status)
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
                        <div class="col-md-4">
                            <label class="form-label">Sort by</label>
                            <select class="form-select form-control-alt" name="sort_by">
                                <option value="id"
                                        @if(old('sort_by') === 'id' || request('sort_by') === 'id') selected @endif>
                                    Default
                                </option>
                                <option value="equipment_equipment_name"
                                        @if(old('sort_by') === 'equipment_equipment_name' || request('sort_by') === 'equipment_equipment_name') selected @endif>
                                    Equipment
                                </option>
                                <option value="user_name"
                                        @if(old('sort_by') === 'user_name' || request('sort_by') === 'user_name') selected @endif>
                                    User
                                </option>
                                <option value="due_date"
                                        @if(old('sort_by') === 'due_date' || request('sort_by') === 'due_date') selected @endif>
                                    Due Date
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-12 text-end">
                            <a href="{{ route('work-orders.index') }}" class="btn btn-warning">
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
        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">All Work Orders</h3>
                <div class="block-options">
                    <a href="{{ route('work-orders.create') }}">
                        <button type="button" class="btn btn-alt-primary btn-sm">
                            <i class="si si-plus"></i> Add Order
                        </button>
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-vcenter fs-sm">
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
                    @foreach ($workOrders as $i => $order)
                        <tr>
                            <td class="text-center">
                                {{ $workOrders->firstItem() + $i }}
                            </td>
                            <td class="fw-semibold">
                                <a href="{{ route('equipments.show', ['equipment' => $order->equipment]) }}">
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
                                    @if($order->status == \App\Enums\WorkOrderStatusEnum::PENDING)
                                        <a href="{{ route('work-orders.edit', ['workOrder' => $order]) }}">
                                            <button type="button" class="btn btn-sm btn-alt-warning">
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </button>
                                        </a>
                                        <form class="form-delete"
                                              action="{{ route('work-orders.destroy', ['workOrder' => $order]) }}"
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

                {{ $workOrders->links() }}
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
@endsection
