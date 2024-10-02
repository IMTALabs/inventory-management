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
                        List
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
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control form-control-alt" name="name" placeholder="Name"
                                   value="{{ $name }}" id="name">
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-control js-select2 form-select form-control-alt" name="type" id="type">
                                <option value="">Select Type</option>
                                @foreach(\App\Enums\EquipmentTypeEnum::cases() as $key => $value)
                                    <option value="{{ $value }}"
                                            @if($type == $value->value) selected @endif>{{ $value->value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control js-select2 form-select form-control-alt" name="status"
                                    id="status">
                                <option value="">Select Status</option>
                                @foreach(\App\Enums\EquipmentStatusEnum::cases() as $key => $value)
                                    <option value="{{ $value }}"
                                            @if($status == $value->value) selected @endif>{{ $value->value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label for="condition" class="form-label">Condition</label>
                            <select class="form-control js-select2 form-select form-control-alt" name="condition"
                                    id="condition">
                                <option value="">Select Condition</option>
                                @foreach(\App\Enums\EquipmentConditionEnum::cases() as $key => $value)
                                    <option value="{{ $value }}"
                                            @if($condition == $value) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mt-2">
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
                <div class="block-options">
                    <a href="{{route('equipments.create')}}">
                        <button type="button" class="btn btn-alt-primary btn-sm">
                            <i class="si si-plus"></i> Add Equipment
                        </button>
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                <table class="table table-striped table-vcenter fs-sm">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th>Name</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Serial Number</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Condition</th>
                        {{--                        <th>Location</th>--}}
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($entries as $i => $entry)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>

                            <td class="fw-semibold">
                                <a href="{{ route('equipments.show', ['equipment' => $entry]) }}">{{ $entry->equipment_name }}</a>
                            </td>
                            <td class="text-center">
                                {{ $entry->equipment_type }}
                            </td>
                            <td class="text-center barcode" title="{{ $entry->serial_number }}">
                                {!! DNS1D::getBarcodeHTML($entry->serial_number, 'C128') !!}
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
                                @if($entry->equipment_condition === 'Good')
                                    <i class="fa fa-check-circle text-success"></i>
                                @elseif($entry->equipment_condition === 'Fair')
                                    <i class="fa fa-exclamation-circle text-warning"></i>
                                @elseif($entry->equipment_condition === 'Poor')
                                    <i class="fa fa-times-circle text-danger"></i>
                                @elseif($entry->equipment_condition === 'Excellent')
                                    <i class="fa fa-star text-primary"></i>
                                @else
                                    <i class="fa fa-question-circle text-muted"></i>
                                @endif
                            </td>
                            {{--                            <td>--}}
                            {{--                                {{ $entry->location }}--}}
                            {{--                            </td>--}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('equipments.edit', ['equipment' => $entry]) }}"
                                       class="btn btn-sm btn-alt-warning">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </a>
                                    <form class="form-delete"
                                          action="{{ route('equipments.destroy', ['equipment' => $entry]) }}"
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
