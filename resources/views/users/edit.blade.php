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
                        Edit
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Invent</a>
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
        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    User Detail
                </h3>
                <div class="block-options">
                    <button type="submit" form="create" class="btn btn-alt-success btn-sm">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <form id="create" action="{{ route('users.update', ['user' => $user]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-6">
                            <label class="form-label">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-alt @error('name') is-invalid @enderror"
                                   placeholder="Name" name="name" value="{{ old('name') ?? $user->name }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email"
                                   class="form-control form-control-alt @error('email') is-invalid @enderror"
                                   placeholder="Email" name="email" value="{{ old('email') ?? $user->email }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label">Password<span class="text-danger">*</span></label>
                            <input type="password" disabled
                                   class="form-control form-control-alt opacity-50"
                                   placeholder="Password">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Role<span class="text-danger">*</span></label>
                            <select class="form-select form-control-alt @error('role') is-invalid @enderror"
                                    name="role">
                                @foreach(\App\Enums\RoleEnum::cases() as $availableRole)
                                    <option value="{{ $availableRole->value }}"
                                            @if(old('role') === $availableRole->value || $user->role->value === $availableRole->value) selected @endif>
                                        {{ ucfirst($availableRole->value) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
@endsection
