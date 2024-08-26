@extends('layouts.backend')

@section('title', __('Users'))

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        {{$equipment->equipment_name}}
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Detail
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Invent</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Detail
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Equipment Detail
                </h3>
                <a class="block-options" href="{{ route('equipments.edit', ['equipment' => $equipment]) }}">
                    <button class="btn btn-alt-warning btn-sm">
                        <i class="fa fa-pen"></i> Edit
                    </button>
                </a>
            </div>
            <div class="block-content block-content-full">
                <div id="create">
                    <div class="row g-4">
                        <div class="col-6">
                            <input type="text" class="form-control form-control-alt" disabled
                                   placeholder="Name" name="name" value="{{ $equipment->equipment_name }}">
                        </div>
                        <div class="col-6">
                            <input type="text"
                                   class="form-control form-control-alt" disabled
                                   placeholder="Type" name="equipment_type" value="{{ $equipment->equipment_type }}">
                        </div>
                        <div class="col-6">
                            <input type="number"
                                   class="form-control form-control-alt" disabled
                                   placeholder="Serial number" name="serial_number" value="{{ $equipment->serial_number }}">
                        </div>
                        <div class="col-6">
                            <input type="text"
                                   class="form-control form-control-alt" disabled
                                   placeholder="Condition" name="equipment_condition" value="{{ $equipment->equipment_condition }}">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
@endsection
