@extends('layouts.backend')

@section('title', 'Metrics')

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    @vite('resources/js/pages/metrics.js')
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Performance History
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
                        <li class="breadcrumb-item">
                            Performance
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            History
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        @include('common.alert')
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Performance History
                </h3>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                <table class="table table-striped table-vcenter fs-sm">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th>Equipment</th>
                        <th>Metric</th>
                        <th>Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($performanceHistories as $i => $performanceHistory)
                        <tr>
                            <td class="text-center">
                                {{ $performanceHistories->firstItem() + $i }}
                            </td>
                            <td>
                                {{ $performanceHistory->equipment->equipment_name }}
                            </td>
                            <td class="fw-semibold">
                                {{ $performanceHistory->metric?->name }}: {{ number_format($performanceHistory->metric_value) }} {{ $performanceHistory->metric?->unit }}
                            </td>
                            <td>
                                {{ $performanceHistory->created_at }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="simple-paginate">
                    {{ $performanceHistories->onEachSide(0)->links() }}
                </div>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
@endsection
