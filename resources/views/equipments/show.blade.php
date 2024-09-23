@extends('layouts.backend')

@section('title', __('Show Equipment Details'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Show Equipment Details</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">View equipment details</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Show Equipment Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        @include('common.alert')
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Equipment Details</h3>
            </div>
            <div class="block-content block-content-full">
                <div class="row g-4">
                    <div class="col-6">
                        <label for="equipment_name" class="form-label">Equipment Name</label>
                        <input type="text" class="form-control" id="equipment_name" value="{{ $equipment->equipment_name }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="equipment_type" class="form-label">Equipment Type</label>
                        <input type="text" class="form-control" id="equipment_type" value="{{ $equipment->equipment_type }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" value="{{ $equipment->model }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="serial_number" class="form-label">Serial Number</label>
                        <input type="text" class="form-control" id="serial_number" value="{{ $equipment->serial_number }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="manufacturer" class="form-label">Manufacturer</label>
                        <input type="text" class="form-control" id="manufacturer" value="{{ $equipment->manufacturer }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="purchase_date" class="form-label">Purchase Date</label>
                        <input type="date" class="form-control" id="purchase_date" value="{{ $equipment->purchase_date->format('Y-m-d') }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" value="{{ $equipment->location }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="status" class="form-label">Equipment Status</label>
                        <input type="text" class="form-control" id="status" value="{{ $equipment->status }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="warranty_period" class="form-label">Warranty Period</label>
                        <input type="date" class="form-control" id="warranty_period" value="{{ $equipment->warranty_period->format('Y-m-d') }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="installation_date" class="form-label">Installation Date</label>
                        <input type="date" class="form-control" id="installation_date" value="{{ $equipment->installation_date->format('Y-m-d') }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="last_service_date" class="form-label">Last Service Date</label>
                        <input type="date" class="form-control" id="last_service_date" value="{{ $equipment->last_service_date->format('Y-m-d') }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="next_service_date" class="form-label">Next Service Date</label>
                        <input type="date" class="form-control" id="next_service_date" value="{{ $equipment->next_service_date->format('Y-m-d') }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="equipment_condition" class="form-label">Equipment Condition</label>
                        <input type="text" class="form-control" id="equipment_condition" value="{{ $equipment->equipment_condition }}" disabled>
                    </div>
                    <div class="col-12">
                        <label for="equipment_specifications" class="form-label">Equipment Specifications</label>
                        <textarea class="form-control" id="equipment_specifications" disabled>{{ $equipment->equipment_specifications }}</textarea>
                    </div>
                    <div class="col-6">
                        <label for="usage_duration" class="form-label">Usage Duration</label>
                        <input type="number" class="form-control" id="usage_duration" value="{{ $equipment->usage_duration }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="power_requirements" class="form-label">Power Requirements</label>
                        <input type="text" class="form-control" id="power_requirements" value="{{ $equipment->power_requirements }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="network_info" class="form-label">Network Info</label>
                        <input type="text" class="form-control" id="network_info" value="{{ $equipment->network_info }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="software_version" class="form-label">Software Version</label>
                        <input type="text" class="form-control" id="software_version" value="{{ $equipment->software_version }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="hardware_version" class="form-label">Hardware Version</label>
                        <input type="text" class="form-control" id="hardware_version" value="{{ $equipment->hardware_version }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="purchase_price" class="form-label">Purchase Price</label>
                        <input type="number" step="0.01" class="form-control" id="purchase_price" value="{{ $equipment->purchase_price }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="depreciation_value" class="form-label">Depreciation Value</label>
                        <input type="number" step="0.01" class="form-control" id="depreciation_value" value="{{ $equipment->depreciation_value }}" disabled>
                    </div>
                    <div class="col-12">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" disabled>{{ $equipment->notes }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="form-label">Images</label>
                    <div id="image_grid" class="row mt-2 px-4">
                        @foreach($equipment->images as $image)
                            <div class="col-md-3 mb-4">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="Image" class="img-fluid fixed-size">
                            </div>
                        @endforeach
                    </div>
                    <hr class="w-100 text-center mt-4">
                    <h4 class="">Warranty</h4>
                    <div class="row g-4">
                        <div class="col-6">
                            <label for="provider_name" class="form-label">Provider Name</label>
                            <input type="text" class="form-control" id="provider_name" value="{{ $equipment->warrantyInformation ? $equipment->warrantyInformation->provider_name : '' }}" disabled>
                        </div>
                        <div class="col-6">
                            <label for="provider_address" class="form-label">Provider Address</label>
                            <input type="text" class="form-control" id="provider_address" value="{{ $equipment->warrantyInformation ? $equipment->warrantyInformation->provider_address : '' }}" disabled>
                        </div>
                        <div class="col-12">
                            <label for="contact_info" class="form-label">Contact Info</label>
                            <input type="text" class="form-control" id="contact_info" value="{{ $equipment->warrantyInformation ? $equipment->warrantyInformation->contact_info : '' }}" disabled>
                        </div>
                        <div class="col-6">
                            <label for="warranty_start_date" class="form-label">Warranty Start Date</label>
                            <input type="date" class="form-control" id="warranty_start_date" value="{{ $equipment->warrantyInformation ? $equipment->warrantyInformation->warranty_start_date->format('Y-m-d') : '' }}" disabled>
                        </div>
                        <div class="col-6">
                            <label for="warranty_end_date" class="form-label">Warranty End Date</label>
                            <input type="date" class="form-control" id="warranty_end_date" value="{{ $equipment->warrantyInformation ? $equipment->warrantyInformation->warranty_end_date->format('Y-m-d') : '' }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite('resources/js/pages/maintenance-plans.js')
    <script type="module">
        One.helpersOnLoad(["jq-select2"]);
    </script>
@endsection
