@extends('admin.layouts.mainlayout')

@section('title', __('admin/common.view'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('admin/menuleft.home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user.manage') }}">{{ __('admin/menuleft.member_management') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('admin/common.view') }}</li>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card">

                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">
                        {{ __('admin/common.view') }}
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('admin/common.username') }}</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->username }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('admin/common.identification') }}</label>
                            <input type="text" class="form-control bg-light" value="{{ $profile->identification ?? '-' }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">{{ __('admin/common.title_name') }}</label>
                            <input type="text" class="form-control bg-light" value="-" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('admin/common.firstname') }}</label>
                            <input type="text" class="form-control bg-light" value="{{ $profile->firstname ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('admin/common.lastname') }}</label>
                            <input type="text" class="form-control bg-light" value="{{ $profile->lastname ?? '-' }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('admin/common.tel') }}</label>
                            <input type="text" class="form-control bg-light" value="{{ $profile->tel ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->email }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">{{ __('admin/common.org_group') }}</label>
                            <input type="text" class="form-control bg-light" value="-" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('admin/common.department') }}</label>
                            <input type="text" class="form-control bg-light" value="-" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('admin/common.station') }}</label>
                            <input type="text" class="form-control bg-light" value="-" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('admin/common.status') }}</label>
                            <div>
                                @if ((int) $user->del_status === 1)
                                    <span class="badge bg-danger">{{ __('admin/common.inactive') }}</span>
                                @else
                                    <span class="badge bg-success">{{ __('admin/common.active') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('admin.user.manage') }}" class="btn btn-outline-secondary">
                            {{ __('admin/common.back') }}
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
