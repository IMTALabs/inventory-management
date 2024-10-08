@extends('layouts.backend')

@section('title', __('Warranty Requests'))

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
                        Warranty Requests
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
                            List Warranty Requests
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
                <form action="{{ route('requests.index') }}" method="get">
                    <div class="row g-2">
                        <div class="col-md-9">
                            <label for="name" class="form-label">Equipment</label>
                            <input type="text" class="form-control form-control-alt" name="equipment_name"
                                   placeholder="Name"
                                   value="{{ $equipment_name }}" id="equipment_name">
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control js-select2 form-select form-control-alt" name="status"
                                    id="status">
                                <option value="">Select Status</option>
                                @foreach(\App\Enums\MaintenanceScheduleStatusEnum::cases() as $key => $value)
                                    <option value="{{ $value }}"
                                            @if($status == $value->value) selected @endif>{{ $value->value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="condition" class="form-label">From Date Request</label>
                            <input type="date"
                                   class="form-control form-control-alt @error('request_date') is-invalid @enderror"
                                   name="from_date" id="from_date" value="{{ $from_date }}">
                            @error('from_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="condition" class="form-label">To Date Request</label>
                            <input type="date"
                                   class="form-control form-control-alt @error('request_date') is-invalid @enderror"
                                   name="to_date" id="to_date" value="{{ $to_date }}">
                            @error('to_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <label class="form-label">Sort by</label>
                            <select class="form-select form-control-alt" name="sort_by">
                                <option value="" @if(request('sort_by') == '') selected @endif>
                                    Select option
                                </option>
                                <option value="equipment_name"
                                        @if(request('sort_by') == 'equipment_name') selected @endif>
                                    Equipment Name
                                </option>
                                <option value="warranty_name"
                                        @if(request('sort_by') == 'warranty_name') selected @endif>
                                    Warranty Name
                                </option>
                                <option value="status"
                                        @if(request('sort_by') == 'status') selected @endif>
                                    Status
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 text-end mt-2">
                        <a href="{{ route('requests.index') }}" class="btn btn-warning">
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
                <h3 class="block-title">All Request Warranty</h3>
                <div class="block-options">
                    <a href="{{route('requests.create')}}">
                        <button type="button" class="btn btn-alt-primary btn-sm">
                            <i class="si si-plus"></i> Add Request Warranty
                        </button>
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                <table class="table table-striped table-vcenter fs-sm">
                    <thead>
                    <tr>
                        <th style="width: 80px;">#</th>
                        <th>Equipment Name</th>
                        <th>Warranty Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Request Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($entries as $key => $value)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="fw-semibold">
                                <a href="{{ route('equipments.show', ['equipment' => $value->equipment]) }}">{{ $value->equipment->equipment_name }}</a>
                            </td>
                            <td>{{ $value->warrantyInformation->provider_name }}</td>
                            <td class="text-center">
                                <span class="badge {{ $value->status->getBadgeClass() }}">
                                    {{ strtoupper($value->status->value) }}
                                </span>
                            </td>
                            <td class="text-center">{{ $value->request_date->format('Y-m-d') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('requests.show', ['request' => $value]) }}">
                                        <button type="button" class="btn btn-sm btn-alt-info">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </button>
                                    </a>
                                    @if($value->status == \App\Enums\MaintenanceScheduleStatusEnum::PENDING)
                                        <a href="{{ route('requests.edit', ['request' => $value]) }}">
                                            <button type="button" class="btn btn-sm btn-alt-warning">
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </button>
                                        </a>
                                        @can('delete', $value)
                                            <form class="form-delete"
                                                  action="{{ route('requests.destroy', ['request' => $value]) }}"
                                                  method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-alt-danger">
                                                    <i class="fa fa-fw fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
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
