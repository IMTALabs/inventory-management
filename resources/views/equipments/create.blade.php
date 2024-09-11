@extends('layouts.backend')

@section('title', __('Equipments'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzone/min/dropzone.min.css') }}">
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Equipments</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Create</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Invent</a>
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
                            <input type="text"
                                   class="form-control form-control-alt @error('equipment_name') is-invalid @enderror"
                                   placeholder="Name" name="equipment_name" value="{{ old('equipment_name') }}">
                            @error('equipment_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text"
                                   class="form-control form-control-alt @error('equipment_type') is-invalid @enderror"
                                   placeholder="Type" name="equipment_type" value="{{ old('equipment_type') }}">
                            @error('equipment_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="number"
                                   class="form-control form-control-alt @error('serial_number') is-invalid @enderror"
                                   placeholder="Serial number" name="serial_number">
                            @error('serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="text"
                                   class="form-control form-control-alt @error('equipment_condition') is-invalid @enderror"
                                   placeholder="Condition" name="equipment_condition">
                            @error('equipment_condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <input type="file" id="images" name="images[]" multiple class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <div class="dropzone" id="equipment-dropzone"></div>
                    </div>
                    <input type="hidden" name="additional_data" id="additional_data">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script>
        const fileImages = [];
        Dropzone.options.equipmentDropzone = {
            url: '{{ route('images.create') }}',
            paramName: 'images', // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            dictDefaultMessage: 'Drop files here or click to upload',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            init: function() {
                this.on('success', function(file, response) {
                    console.log(file);
                    console.log(response);
                    fileImages.push(file);
                    console.log('File uploaded successfully');
                });
                this.on('error', function(file, response) {
                    console.log('File upload error');
                });
            }
        };

        document.getElementById('create').addEventListener('submit', function() {
            const additionalData = document.getElementById('additional_data');
            additionalData.value = JSON.stringify(fileImages);
        });
    </script>
@endsection
