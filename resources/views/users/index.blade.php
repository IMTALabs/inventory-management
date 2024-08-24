@extends('layouts.backend')

@section('title', __('Users'))

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Page JS Code -->
    @vite(['resources/js/pages/users.js'])
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Users
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
                            List
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
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

        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">All Users</h3>
                <div class="block-options">
                    <a href="{{ route('users.create') }}">
                        <button type="button" class="btn btn-alt-primary btn-sm">
                            <i class="si si-plus"></i> Add User
                        </button>
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form class="row g-2 align-items-center mb-3" action="{{ route('users.index') }}" method="get">
                    <div class="col-3">
                        <select class="form-select form-control-alt" name="role">
                            <option value="">All roles</option>
                            @foreach(\App\Enums\RoleEnum::cases() as $availableRole)
                                <option value="{{ $availableRole->value }}"
                                        @if($role === $availableRole->value) selected @endif>
                                    {{ ucfirst($availableRole->value) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-7">
                        <input type="text" class="form-control form-control-alt" name="q" placeholder="Name or Email"
                               value="{{ $q }}">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-dark w-100">Filter</button>
                    </div>
                </form>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                <table class="table table-striped table-vcenter fs-sm">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th class="text-center" style="width: 80px;">Role</th>
                        <th>Name</th>
                        <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $i => $user)
                        <tr>
                            <td class="text-center">
                                {{ $users->firstItem() + $i }}
                            </td>
                            <td class="text-center">
                                @if ($user->is_admin)
                                    <span class="badge bg-success">Admin</span>
                                @else
                                    <span class="badge bg-info">Staff</span>
                                @endif
                            </td>
                            <td class="fw-semibold">
                                <a href="{{ route('users.show', ['user' => $user]) }}">{{ $user->name }}</a>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ $user->email }}
                            </td>
                            <td class="text-center d-flex justify-content-center gap-1">
                                <a href="{{ route('users.edit', ['user' => $user]) }}">
                                    <button type="button" class="btn btn-sm btn-alt-warning">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </button>
                                </a>
                                <form class="form-delete" action="{{ route('users.destroy', ['user' => $user]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-alt-danger">
                                        <i class="fa fa-fw fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $users->onEachSide(5)->links() }}
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
@endsection
