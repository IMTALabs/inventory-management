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
                            <label for="equipment_name" placeholder="Equipment Name" class="form-label">Equipment
                                Name<span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('equipment_name') is-invalid @enderror"
                                   placeholder="Equipment Name" name="equipment_name" id="equipment_name"
                                   value="{{ old('equipment_name') ?? $equipment->equipment_name }}">
                            @error('equipment_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="equipment_type" placeholder="Equipment Type" class="form-label">Equipment
                                Type<span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('equipment_type') is-invalid @enderror"
                                   placeholder="Equipment Type" name="equipment_type" id="equipment_type"
                                   value="{{ old('equipment_type') ?? $equipment->equipment_type }}">
                            @error('equipment_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="model" placeholder="Model" class="form-label">Model<span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('model') is-invalid @enderror"
                                   placeholder="Model" name="model" id="model"
                                   value="{{ old('model') ?? $equipment->model }}">
                            @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="serial_number" placeholder="Serial Number" class="form-label">Serial Number<span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('serial_number') is-invalid @enderror"
                                   placeholder="Serial Number" name="serial_number" id="serial_number"
                                   value="{{ old('serial_number') ?? $equipment->serial_number }}">
                            @error('serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="manufacturer" placeholder="Manufacturer" class="form-label">Manufacturer<span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('manufacturer') is-invalid @enderror"
                                   placeholder="Manufacturer" name="manufacturer" id="manufacturer"
                                   value="{{ old('manufacturer') ?? $equipment->manufacturer }}">
                            @error('manufacturer')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="purchase_date" placeholder="Purchase Date" class="form-label">Purchase Date<span
                                    class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control form-control-alt @error('purchase_date') is-invalid @enderror"
                                   placeholder="Purchase Date" name="purchase_date" id="purchase_date"
                                   value="{{ old('purchase_date') ?? $equipment->purchase_date }}">
                            @error('purchase_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="location" placeholder="Location" class="form-label">Location<span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('location') is-invalid @enderror"
                                   placeholder="Location" name="location" id="location"
                                   value="{{ old('location') ?? $equipment->location }}">
                            @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="status" placeholder="Status" class="form-label">Status<span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('status') is-invalid @enderror"
                                   placeholder="Status" name="status" id="status"
                                   value="{{ old('status', 'Active') ?? $equipment->status }}">
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="warranty_period" placeholder="Warranty Period" class="form-label">Warranty
                                Period<span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control form-control-alt @error('warranty_period') is-invalid @enderror"
                                   placeholder="Warranty Period" name="warranty_period" id="warranty_period"
                                   value="{{ old('warranty_period') ?? $equipment->warranty_period }}">
                            @error('warranty_period')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="installation_date" placeholder="Installation Date" class="form-label">Installation
                                Date<span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control form-control-alt @error('installation_date') is-invalid @enderror"
                                   placeholder="Installation Date" name="installation_date" id="installation_date"
                                   value="{{ old('installation_date') ?? $equipment->installation_date }}">
                            @error('installation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="last_service_date" placeholder="Last Service Date" class="form-label">Last
                                Service Date<span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control form-control-alt @error('last_service_date') is-invalid @enderror"
                                   placeholder="Last Service Date" name="last_service_date" id="last_service_date"
                                   value="{{ old('last_service_date') ?? $equipment->last_service_date }}">
                            @error('last_service_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="next_service_date" placeholder="Next Service Date" class="form-label">Next
                                Service Date<span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control form-control-alt @error('next_service_date') is-invalid @enderror"
                                   placeholder="Next Service Date" name="next_service_date" id="next_service_date"
                                   value="{{ old('next_service_date') ?? $equipment->next_service_date }}">
                            @error('next_service_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="equipment_condition" placeholder="Equipment Condition" class="form-label">Equipment
                                Condition<span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('equipment_condition') is-invalid @enderror"
                                   placeholder="Equipment Condition" name="equipment_condition" id="equipment_condition"
                                   value="{{ old('equipment_condition', 'Good') ?? $equipment->equipment_condition }}">
                            @error('equipment_condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="equipment_specifications" placeholder="Equipment Specifications"
                                   class="form-label">Equipment Specifications<span class="text-danger">*</span></label>
                            <textarea
                                class="form-control form-control-alt @error('equipment_specifications') is-invalid @enderror"
                                placeholder="Equipment Specifications" name="equipment_specifications"
                                id="equipment_specifications">{{ old('equipment_specifications') ?? $equipment->equipment_specifications }}</textarea>
                            @error('equipment_specifications')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="usage_duration" placeholder="Usage Duration" class="form-label">Usage
                                Duration<span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control form-control-alt @error('usage_duration') is-invalid @enderror"
                                   placeholder="Usage Duration" name="usage_duration" id="usage_duration"
                                   value="{{ old('usage_duration') ?? $equipment->usage_duration }}">
                            @error('usage_duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="power_requirements" placeholder="Power Requirements" class="form-label">Power
                                Requirements<span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('power_requirements') is-invalid @enderror"
                                   placeholder="Power Requirements" name="power_requirements" id="power_requirements"
                                   value="{{ old('power_requirements') ?? $equipment->power_requirements }}">
                            @error('power_requirements')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="network_info" placeholder="Network Info" class="form-label">Network Info</label>
                            <input type="text"
                                   class="form-control form-control-alt @error('network_info') is-invalid @enderror"
                                   placeholder="Network Info" name="network_info" id="network_info"
                                   value="{{ old('network_info') ?? $equipment->network_info }}">
                            @error('network_info')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="software_version" placeholder="Software Version" class="form-label">Software
                                Version<span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('software_version') is-invalid @enderror"
                                   placeholder="Software Version" name="software_version" id="software_version"
                                   value="{{ old('software_version') ?? $equipment->software_version }}">
                            @error('software_version')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="hardware_version" placeholder="Hardware Version" class="form-label">Hardware
                                Version<span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-alt @error('hardware_version') is-invalid @enderror"
                                   placeholder="Hardware Version" name="hardware_version" id="hardware_version"
                                   value="{{ old('hardware_version') ?? $equipment->hardware_version }}">
                            @error('hardware_version')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="purchase_price" placeholder="Purchase Price" class="form-label">Purchase
                                Price<span class="text-danger">*</span></label>
                            <input type="number" step="0.01"
                                   class="form-control form-control-alt @error('purchase_price') is-invalid @enderror"
                                   placeholder="Purchase Price" name="purchase_price" id="purchase_price"
                                   value="{{ old('purchase_price') ?? $equipment->purchase_price }}">
                            @error('purchase_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="depreciation_value" placeholder="Depreciation Value" class="form-label">Depreciation
                                Value<span class="text-danger">*</span></label>
                            <input type="number" step="0.01"
                                   class="form-control form-control-alt @error('depreciation_value') is-invalid @enderror"
                                   placeholder="Depreciation Value" name="depreciation_value" id="depreciation_value"
                                   value="{{ old('depreciation_value') ?? $equipment->depreciation_value }}">
                            @error('depreciation_value')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="notes" placeholder="Notes" class="form-label">Notes<span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control form-control-alt @error('notes') is-invalid @enderror"
                                      placeholder="Notes" name="notes"
                                      id="notes">{{ old('notes') ?? $equipment->notes }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="additional_data" id="additional_data">
                </form>
                <div class="mt-4">
                    <div class="d-flex justify-content-between">
                        <label class="form-label">Image<span
                                class="text-danger">*</span></label>
                        <div class="form-check d-flex">
                            <input type="checkbox" name="use_old_image" checked id="use_old_image">
                            <label for="use_old_image" class="form-check ml-1">
                                Use old image
                            </label>
                        </div>
                    </div>

                    <form method="post" action="{{ route('images.create') }}" enctype="multipart/form-data"
                          class="dropzone mt-2" id="dropzone" style="display: none">
                        @csrf
                    </form>

                    <div id="image_grid" class="row mt-2 px-4">

                        @foreach($equipment->images as $image)
                            <div class="col-md-3 mb-4">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="Image" class="img-fluid fixed-size">
                            </div>
                        @endforeach
                    </div>
                </div>

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
        document.getElementById("create").addEventListener("submit", function () {
            const additionalData = document.getElementById("additional_data");
            additionalData.value = JSON.stringify(fileImages);
        });

        function toggleImageInput() {
            const useOldImage = document.getElementById("use_old_image").checked;
            document.getElementById("image_grid").style.display = useOldImage ? "" : "none";
            document.getElementById("dropzone").style.display = useOldImage ? "none" : "block";
        }

        // Initialize the visibility on page load
        document.addEventListener("DOMContentLoaded", function () {
            toggleImageInput();
            document.getElementById("use_old_image").addEventListener("change", toggleImageInput);
        });
    </script>
@endsection
