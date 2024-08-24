@extends('layouts.backend')

@section('title', __('Monitor'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chart.js/chart.umd.js') }}"></script>
    <script>
      const metrics = @json($metrics->pluck('chart_key') ?? []);
      const currentEquipment = @json($currentEquipment ?? null);
      const chartData = {
          @forEach($metrics as $metric)
          "{{ $metric->chart_key }}": {
            labels: @json($currentEquipment?->performanceMetrics->get($metric->id)?->pluck('created_at')->map(fn ($item) => $item->format('Y-m-d H:i:s')) ?? []),
            datasets: [
              {
                label: "{{ $metric->name }}",
                fill: true,
                backgroundColor: "rgba(171, 227, 125, .5)",
                borderColor: "rgba(171, 227, 125, 1)",
                pointBackgroundColor: "rgba(171, 227, 125, 1)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(171, 227, 125, 1)",
                data: @json($currentEquipment?->performanceMetrics->get($metric->id)?->pluck('metric_value') ?? [])
              }
            ]
          },
          @endforeach
      };
    </script>
    @vite('resources/js/pages/monitor.js')
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
                        Monitor
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Tracking equipment performance
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Invent</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Monitor
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
                    Equipment
                </h3>
            </div>
            <div class="block-content block-content-full">
                <form action="{{ route('monitor.show') }}">
                    <div class="row g-2">
                        <div class="col-9">
                            <select class="js-select2 form-select" name="equipment_id"
                                    style="width: 100%;" data-placeholder="Choose one equipment...">
                                <option></option>
                                @foreach($equipments as $equipment)
                                    <option value="{{ $equipment->id }}"
                                            @if($equipment->id == $equipmentId) selected @endif>
                                        {{ $equipment->equipment_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-alt-primary w-100">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if($currentEquipment)
            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                    @foreach($metrics as $metric)
                        <li class="nav-item">
                            <button class="nav-link @if($loop->first) active @endif"
                                    id="btabs-animated-fade-{{ Str::slug($metric->name) }}-tab" data-bs-toggle="tab"
                                    data-bs-target="#btabs-animated-fade-{{ Str::slug($metric->name) }}" role="tab"
                                    aria-controls="btabs-animated-fade-{{ Str::slug($metric->name) }}"
                                    aria-selected="true">
                                {{ $metric->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    @foreach($metrics as $metric)
                        <div class="tab-pane fade @if($loop->first) show active @endif"
                             id="btabs-animated-fade-{{ Str::slug($metric->name) }}" role="tabpanel"
                             aria-labelledby="btabs-animated-fade-{{ Str::slug($metric->name) }}-tab" tabindex="0">
                            <div class="py-3" style="height: 360px">
                                <!-- Lines Chart Container -->
                                <canvas id="js-chartjs-{{ $metric->chart_key }}"></canvas>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <!-- END Page Content -->
@endsection
