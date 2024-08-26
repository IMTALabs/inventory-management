<section>
    @session('status')
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <div class="flex-shrink-0">
            <i class="fa fa-fw fa-check"></i>
        </div>
        <div class="flex-grow-1 ms-3">
            <p class="mb-0">
                {{ session('status') }}
            </p>
        </div>
    </div>
    @endsession
    @session('error')
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <div class="flex-shrink-0">
            <i class="fa fa-fw fa-exclamation-triangle"></i>
        </div>
        <div class="flex-grow-1 ms-3">
            <p class="mb-0">
                {{ session('error') }}
            </p>
        </div>
    </div>
    @endsession
    @session('warning')
    <div class="alert alert-warning d-flex align-items-center" role="alert">
        <div class="flex-shrink-0">
            <i class="fa fa-fw fa-exclamation"></i>
        </div>
        <div class="flex-grow-1 ms-3">
            <p class="mb-0">
                {{ session('warning') }}
            </p>
        </div>
    </div>
    @endsession
    @session('info')
    <div class="alert alert-info d-flex align-items-center" role="alert">
        <div class="flex-shrink-0">
            <i class="fa fa-fw fa-info"></i>
        </div>
        <div class="flex-grow-1 ms-3">
            <p class="mb-0">
                {{ session('info') }}
            </p>
        </div>
    </div>
    @endsession
</section>
