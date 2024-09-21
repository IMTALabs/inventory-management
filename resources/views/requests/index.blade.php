@extends('layouts.backend')

@section('title', __('Request Warranty'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection


@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Request Warranty
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
                            List Request Warranty
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
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control form-control-alt" name="name" placeholder="Name"
                                   value="" id="name">
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-control js-select2 form-select form-control-alt" name="type" id="type">
                                <option value="">Select Type</option>
                                @foreach(App\Models\Equipment::EQUIPMENT_TYPE as $key => $value)
                                    <option value="{{ $value }}"
                                           >{{ $value }}</option>
                                @endforeach
                            </select>
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
                    <a href="{{route('requests.create')}}">
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
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

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
