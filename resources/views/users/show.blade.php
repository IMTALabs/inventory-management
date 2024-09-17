@extends('layouts.backend')

@section('title', __('Users'))

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        {{ $user->name }}
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Detail
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Invent</a>
                        </li>
                        @can('viewAny', \App\Models\User::class)
                            <li class="breadcrumb-item">
                                <a class="link-fx" href="{{ route('users.index') }}">Users</a>
                            </li>
                        @endcan
                        <li class="breadcrumb-item" aria-current="page">
                            {{ $user->name }}
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
                <h3 class="block-title">
                    User Detail
                </h3>
                <a class="block-options" href="{{ route('users.edit', ['user' => $user]) }}">
                    <button class="btn btn-alt-warning btn-sm">
                        <i class="fa fa-pen"></i> Edit
                    </button>
                </a>
            </div>
            <div class="block-content block-content-full">
                <div id="create">
                    <div class="row g-4">
                        <div class="col-6">
                            <label class="form-label">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-alt" disabled
                                   placeholder="Name" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email"
                                   class="form-control form-control-alt" disabled
                                   placeholder="Email" name="email" value="{{ $user->email }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Password<span class="text-danger">*</span></label>
                            <input type="password"
                                   class="form-control form-control-alt opacity-50" disabled
                                   placeholder="Password" name="password">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Role<span class="text-danger">*</span></label>
                            <select class="form-select form-control-alt" disabled
                                    name="role">
                                @foreach(\App\Enums\RoleEnum::cases() as $availableRole)
                                    <option value="{{ $availableRole->value }}"
                                            @if($user->role->value === $availableRole->value) selected @endif>
                                        {{ ucfirst($availableRole->value) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
@endsection
