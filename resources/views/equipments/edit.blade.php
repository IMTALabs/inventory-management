@extends('layouts.backend')

@section('title', __('Equipments'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzone/min/dropzone.min.css') }}">
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Equipments
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Edit
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Invent</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Edit Equipment
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        @include('common.alert')
        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Edit Equipment
                </h3>
                <div class="block-options">
                    <button type="submit" form="edit" class="btn btn-alt-success btn-sm">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form id="edit" action="{{route('equipments.update', ['equipment' => $equipment])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt @error('equipment_name') is-invalid @enderror"
                                   placeholder="Name" name="equipment_name" value="{{ old('equipment_name') ?? $equipment->equipment_name }}">
                            @error('equipment_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text"
                                   class="form-control form-control-alt @error('equipment_type') is-invalid @enderror"
                                   placeholder="Type" name="equipment_type" value="{{ old('equipment_type') ?? $equipment->equipment_name  }}">
                            @error('equipment_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="number"
                                   class="form-control form-control-alt @error('serial_number') is-invalid @enderror"
                                   placeholder="Serial number" name="serial_number" value="{{ old('serial_number') ?? $equipment->serial_number }}">
                            @error('serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text"
                                   class="form-control form-control-alt @error('equipment_condition') is-invalid @enderror"
                                   placeholder="Condition" name="equipment_condition" value="{{ old('equipment_condition') ?? $equipment->equipment_condition }}">
                            @error('equipment_condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <input type="checkbox" id="use_old_image" checked name="use_old_image" onchange="toggleImageInput()">
                            <label for="use_old_image">Use Old Images</label>
                        </div>
                        <div id="image_grid" class="row mt-2 px-4">
                            @foreach($equipment->images as $image)
                                <div class="col-md-3 mb-4">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="Image" class="img-fluid fixed-size">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <input type="hidden" name="additional_data" id="additional_data">
                </form>
                <form method="post" action="{{route('images.create')}}" enctype="multipart/form-data"
                      class="dropzone mt-4" id="dropzone" style="display: none">
                    @csrf
                </form>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <style>
        .fixed-size {
            width: 100%;
            height: 200px; /* Set the desired fixed height */
            object-fit: cover; /* Ensure the image covers the entire area */
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('/js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script>
        function toggleImageInput() {
            const useOldImage = document.getElementById('use_old_image').checked;
            document.getElementById('image_grid').style.display = useOldImage ? '' : 'none';
            document.getElementById('dropzone').style.display = useOldImage ? 'none' : 'block';
        }
        document.addEventListener('DOMContentLoaded', function() {
            toggleImageInput();
        });
        const fileImages = [];
        Dropzone.options.dropzone =
          {
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
        document.getElementById('edit').addEventListener('submit', function() {
          const additionalData = document.getElementById('additional_data');
          additionalData.value = fileImages;
        });
    </script>
@endsection
