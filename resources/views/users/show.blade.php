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
        @include('common.alert')

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

        @if(Auth::id() == $user->id)
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Change Password</h3>
                </div>
                <div class="block-content">
                    <form action="{{ route('users.update-password', $user) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row push">
                            <div class="col-lg-4">
                                <p class="fs-sm text-muted">
                                    Changing your sign in password is an easy way to keep your account secure.
                                </p>
                            </div>
                            <div class="col-lg-8 col-xl-5">
                                <div class="mb-4">
                                    <label class="form-label" for="one-profile-edit-password">Current Password</label>
                                    <input type="password"
                                           class="form-control form-control-alt @error('old_password') is-invalid @enderror"
                                           placeholder="••••••••"
                                           id="one-profile-edit-password"
                                           name="old_password">
                                    @error('old_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label" for="one-profile-edit-password-new">
                                            New Password
                                        </label>
                                        <input type="password"
                                               class="form-control form-control-alt @error('new_password') is-invalid @enderror"
                                               placeholder="••••••••"
                                               id="one-profile-edit-password-new"
                                               name="new_password">
                                        @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label" for="one-profile-edit-password-new-confirm">
                                            Confirm New Password
                                        </label>
                                        <input type="password"
                                               class="form-control form-control-alt @error('new_password_confirmation') is-invalid @enderror"
                                               placeholder="••••••••"
                                               id="one-profile-edit-password-new-confirm"
                                               name="new_password_confirmation">
                                        @error('new_password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-alt-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Equipments Assigned
                </h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-vcenter fs-sm">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th>Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Condition</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($user->workOrders as $i => $entry)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>

                            <td class="fw-semibold">
                                <a href="{{ route('equipments.edit', $entry->equipment) }}">
                                    {{ $entry->equipment->equipment_name }}
                                </a>
                            </td>
                            <td class="text-center" title="{{ $entry->equipment->status->value }}">
                                @switch($entry->equipment->status->value)
                                    @case('Available')
                                        <span class="badge bg-success text-white">Available</span>
                                        @break
                                    @case('In Use')
                                        <span class="badge bg-info text-white">In Use</span>
                                        @break
                                    @case('Inactive')
                                        <span class="badge bg-danger text-white">Inactive</span>
                                        @break
                                    @case('Pending Disposal')
                                        <span class="badge bg-warning text-white">Pending Disposal</span>
                                        @break
                                    @case('Under Maintenance')
                                        <span class="badge bg-info text-white">Under Maintenance</span>
                                        @break
                                    @case('Under Repair')
                                        <span class="badge bg-primary text-white">Under Repair</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary text-white">Unknown</span>
                                @endswitch
                            </td>
                            <td class="text-center" title="{{ $entry->equipment->equipment_condition }}">
                                @switch($entry->equipment->equipment_condition)
                                    @case('Good')
                                        <i class="fa fa-check-circle text-success"></i> Good
                                        @break
                                    @case('Fair')
                                        <i class="fa fa-exclamation-circle text-warning"></i> Fair
                                        @break
                                    @case('Poor')
                                        <i class="fa fa-times-circle text-danger"></i> Poor
                                        @break
                                    @case('Excellent')
                                        <i class="fa fa-star text-primary"></i> Excellent
                                        @break
                                    @default
                                        <i class="fa fa-question-circle text-muted"></i> Unknown
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
