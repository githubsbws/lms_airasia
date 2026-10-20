@extends('admin.layouts.mainlayout')

@section('title', __('admin/permission.permission_manage'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('admin/menuleft.home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user.manage') }}">{{ __('admin/menuleft.admin_user_manage') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('admin/permission.permission_manage') }}</li>
@endsection

@section('content')

    <div class="card">
        <div class="card-body">

            <h5 class="mb-3">{{ $fullname }}</h5>

            {{-- สิทธิ์ปัจจุบัน: แสดงให้เห็นชัดก่อนเลือกใหม่ --}}
            <p class="text-muted mb-3">
                {{ __('admin/permission.permission_group_name') }}:
                @if ($currentGroupId !== null)
                    <span class="fw-bold text-dark">
                        {{ $adminGroups->firstWhere('id', $currentGroupId)?->display_name ?? __('admin/permission.no_group') }}
                    </span>
                @else
                    <span class="fw-bold text-dark">{{ __('admin/permission.no_group') }}</span>
                @endif
            </p>

            <form method="POST" action="{{ route('admin.user.manage.permission.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="group" class="form-label">{{ __('admin/permission.permission_group_name') }}</label>
                    <select name="group" id="group" class="form-select">
                        <option value="" {{ $currentGroupId === null ? 'selected' : '' }}>
                            {{ __('admin/permission.no_group') }}
                        </option>
                        @foreach ($adminGroups as $adminGroup)
                            <option value="{{ $adminGroup->id }}" {{ $currentGroupId === $adminGroup->id ? 'selected' : '' }}>
                                {{ $adminGroup->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        {{ __('admin/common.save') }}
                    </button>
                    <a href="{{ route('admin.user.manage') }}" class="btn btn-outline-secondary">
                        {{ __('admin/common.cancel') }}
                    </a>
                </div>
            </form>

        </div>
    </div>

@endsection
