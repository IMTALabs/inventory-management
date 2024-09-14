@extends('layouts.backend')

@section('title', __('Create Equipment'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzone/min/dropzone.min.css') }}">
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Create Equipment</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Add new equipment details</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Create Equipment</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Create Equipment</h3>
                <div class="block-options">
                    <button type="submit" form="create" class="btn btn-alt-success btn-sm">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form id="create" action="{{ route('equipments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('equipment_name') is-invalid @enderror" placeholder="Equipment Name" name="equipment_name" value="{{ old('equipment_name') }}">
                            @error('equipment_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('equipment_type') is-invalid @enderror" placeholder="Equipment Type" name="equipment_type" value="{{ old('equipment_type') }}">
                            @error('equipment_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('model') is-invalid @enderror" placeholder="Model" name="model" value="{{ old('model') }}">
                            @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('serial_number') is-invalid @enderror" placeholder="Serial Number" name="serial_number" value="{{ old('serial_number') }}">
                            @error('serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('manufacturer') is-invalid @enderror" placeholder="Manufacturer" name="manufacturer" value="{{ old('manufacturer') }}">
                            @error('manufacturer')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control form-control-alt @error('purchase_date') is-invalid @enderror" placeholder="Purchase Date" name="purchase_date" value="{{ old('purchase_date') }}">
                            @error('purchase_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('location') is-invalid @enderror" placeholder="Location" name="location" value="{{ old('location') }}">
                            @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('status') is-invalid @enderror" placeholder="Status" name="status" value="{{ old('status', 'Active') }}">
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control form-control-alt @error('warranty_period') is-invalid @enderror" placeholder="Warranty Period" name="warranty_period" value="{{ old('warranty_period') }}">
                            @error('warranty_period')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control form-control-alt @error('installation_date') is-invalid @enderror" placeholder="Installation Date" name="installation_date" value="{{ old('installation_date') }}">
                            @error('installation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control form-control-alt @error('last_service_date') is-invalid @enderror" placeholder="Last Service Date" name="last_service_date" value="{{ old('last_service_date') }}">
                            @error('last_service_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control form-control-alt @error('next_service_date') is-invalid @enderror" placeholder="Next Service Date" name="next_service_date" value="{{ old('next_service_date') }}">
                            @error('next_service_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('equipment_condition') is-invalid @enderror" placeholder="Equipment Condition" name="equipment_condition" value="{{ old('equipment_condition', 'Good') }}">
                            @error('equipment_condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <textarea class="form-control form-control-alt @error('equipment_specifications') is-invalid @enderror" placeholder="Equipment Specifications" name="equipment_specifications">{{ old('equipment_specifications') }}</textarea>
                            @error('equipment_specifications')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="number" class="form-control form-control-alt @error('usage_duration') is-invalid @enderror" placeholder="Usage Duration" name="usage_duration" value="{{ old('usage_duration') }}">
                            @error('usage_duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('power_requirements') is-invalid @enderror" placeholder="Power Requirements" name="power_requirements" value="{{ old('power_requirements') }}">
                            @error('power_requirements')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('network_info') is-invalid @enderror" placeholder="Network Info" name="network_info" value="{{ old('network_info') }}">
                            @error('network_info')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('software_version') is-invalid @enderror" placeholder="Software Version" name="software_version" value="{{ old('software_version') }}">
                            @error('software_version')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('hardware_version') is-invalid @enderror" placeholder="Hardware Version" name="hardware_version" value="{{ old('hardware_version') }}">
                            @error('hardware_version')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" class="form-control form-control-alt @error('purchase_price') is-invalid @enderror" placeholder="Purchase Price" name="purchase_price" value="{{ old('purchase_price') }}">
                            @error('purchase_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" class="form-control form-control-alt @error('depreciation_value') is-invalid @enderror" placeholder="Depreciation Value" name="depreciation_value" value="{{ old('depreciation_value') }}">
                            @error('depreciation_value')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <textarea class="form-control form-control-alt @error('notes') is-invalid @enderror" placeholder="Notes" name="notes">{{ old('notes') }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="additional_data" id="additional_data">
                </form>

                <form method="post" action="{{ route('images.create') }}" enctype="multipart/form-data" class="dropzone mt-4" id="dropzone">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script>
        const fileImages = [];
        Dropzone.options.dropzone = {
            maxFilesize: 10,
            renameFile: function (file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 60000,
            success: function (file, response) {
                fileImages.push(response.image_path);
            },
            error: function (file, response) {
                return false;
            }
        };
        document.getElementById('create').addEventListener('submit', function() {
            const additionalData = document.getElementById('additional_data');
            additionalData.value = JSON.stringify(fileImages);
        });
    </script>
@endsection
