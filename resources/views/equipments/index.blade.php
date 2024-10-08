@extends('layouts.backend')

@section('title', __('Equipment'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite('resources/js/pages/maintenance-schedules.js')
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
                        Equipment
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Update
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Invent</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            List Equipment
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Update Equipment</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="content">
        @include('common.alert')
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <form action="{{ route('equipments.index') }}" method="get">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control form-control-alt" name="name" placeholder="..."
                                   value="{{ $name }}" id="name">
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-control form-select form-control-alt" name="type" id="type">
                                <option value="">...</option>
                                @foreach(\App\Enums\EquipmentTypeEnum::cases() as $key => $value)
                                    <option value="{{ $value }}"
                                            @if($type == $value->value) selected @endif>{{ $value->value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control form-select form-control-alt" name="status"
                                    id="status">
                                <option value="">...</option>
                                @foreach(\App\Enums\EquipmentStatusEnum::cases() as $key => $value)
                                    <option value="{{ $value }}"
                                            @if($status == $value->value) selected @endif>{{ $value->value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="condition" class="form-label">Condition</label>
                            <select class="form-control form-select form-control-alt" name="condition"
                                    id="condition">
                                <option value="">...</option>
                                @foreach(\App\Enums\EquipmentConditionEnum::cases() as $key => $value)
                                    <option value="{{ $value }}"
                                            @if($condition == $value) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="form-label">Sort by</label>
                            <select class="form-select form-control-alt" name="sort_by">
                                <option value="" @if(request('sort_by') == '') selected @endif>
                                    Default
                                </option>
                                <option value="equipment_name"
                                        @if(request('sort_by') == 'equipment_name') selected @endif>
                                    Name
                                </option>
                                <option value="equipment_type"
                                        @if(request('sort_by') == 'equipment_type') selected @endif>
                                    Type
                                </option>
                                <option value="status"
                                        @if(request('sort_by') == 'status') selected @endif>
                                    Status
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="form-label">Sort order</label>
                            <select class="form-select form-control-alt" name="sort_order">
                                <option value="asc" @if(request('sort_order') == 'asc') selected @endif>
                                    Ascending
                                </option>
                                <option value="desc"
                                        @if(!request('sort_order') || request('sort_order') == 'desc') selected @endif>
                                    Descending
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 text-end mt-2">
                        <a href="{{ route('equipments.index') }}" class="btn btn-warning">
                            <i class="fa fa-undo"></i> Reset
                        </a>
                        <button type="submit" class="btn btn-dark">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">All Equipments</h3>
                @can('create', \App\Models\Equipment::class)
                    <div class="block-options">
                        <a href="{{route('equipments.create')}}">
                            <button type="button" class="btn btn-alt-primary btn-sm">
                                <i class="si si-plus"></i> Add Equipment
                            </button>
                        </a>
                    </div>
                @endcan
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-vcenter fs-sm">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th>Name</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Serial Number</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Condition</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($entries as $i => $entry)
                        @php
                            /**
                             * @var \App\Models\Equipment $entry
                             */
                        @endphp
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>

                            <td class="fw-semibold">
                                <a href="{{ route('equipments.show', ['equipment' => $entry]) }}">{{ $entry->equipment_name }}</a>
                            </td>
                            <td class="text-center">
                                {{ $entry->equipment_type }}
                            </td>
                            <td class="text-center barcode" title="{{ $entry->serial_number }}">
                                <span class="badge bg-secondary text-white">
                                    {{ $entry->serial_number }}
                                </span>
                            </td>
                            <td class="text-center" title="{{ $entry->status }}">
                                @if($entry->status->value == 'Available')
                                    <span class="badge bg-success text-white"> Available</span>
                                @elseif($entry->status->value == 'Inactive')
                                    <span class="badge bg-danger text-white"> Inactive</span>
                                @elseif($entry->status->value == 'Pending Disposal')
                                    <span class="badge bg-warning text-white">Pending Disposal</span>
                                @elseif($entry->status->value == 'In Use')
                                    <span class="badge bg-warning text-white">In Use</span>
                                @elseif($entry->status->value == 'Under Maintenance')
                                    <span class="badge bg-info text-white">Under Maintenance</span>
                                @elseif($entry->status->value == 'Under Repair')
                                    <span class="badge bg-primary text-white">Under Repair</span>
                                @else
                                    <span class="badge bg-secondary text-white">Unknown</span>
                                @endif
                            </td>
                            <td class="text-center" title="{{ $entry->equipment_condition }}">
                                <span @class(['badge', $entry->equipment_condition->getBadgeClass()])>
                                    {{ $entry->equipment_condition }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('equipments.show', ['equipment' => $entry]) }}">
                                        <button type="button" class="btn btn-sm btn-alt-info">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </button>
                                    </a>
                                    @can('update', $entry)
                                        <a href="{{ route('equipments.edit', ['equipment' => $entry]) }}"
                                           class="btn btn-sm btn-alt-warning">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </a>
                                    @endcan
                                    @can('delete', $entry)
                                        <form class="form-delete"
                                              action="{{ route('equipments.destroy', ['equipment' => $entry]) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-alt-danger">
                                                <i class="fa fa-fw fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $entries->onEachSide(0)->links() }}
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
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
