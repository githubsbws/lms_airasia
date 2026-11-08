@extends('admin.layouts.mainlayout')

@section('title', __('admin/menuleft.how_to_create'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('admin/menuleft.home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.howto.list') }}">{{ __('admin/menuleft.how_to') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('admin/menuleft.how_to_create') }}</li>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card">

                <div class="card-header bg-danger">
                    <h3 class="card-title text-white">
                        {{ __('admin/menuleft.how_to_create') }}
                    </h3>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.howto.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="how_to_name_th" class="form-label">
                                {{ __('admin/howto.name_th') }}<span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="how_to_name_th"
                                id="how_to_name_th"
                                class="form-control @error('how_to_name_th') is-invalid @enderror"
                                value="{{ old('how_to_name_th') }}"
                                maxlength="255"
                                required>
                            @error('how_to_name_th')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="how_to_name_en" class="form-label">
                                {{ __('admin/howto.name_en') }}<span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="how_to_name_en"
                                id="how_to_name_en"
                                class="form-control @error('how_to_name_en') is-invalid @enderror"
                                value="{{ old('how_to_name_en') }}"
                                maxlength="255"
                                required>
                            @error('how_to_name_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <p class="text-muted small">
                            {{ __('admin/howto.upload_hint') }}
                        </p>

                        <div class="mt-3">
                            <a href="{{ route('admin.howto.list') }}" class="btn btn-outline-secondary">
                                {{ __('admin/common.back') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                {{ __('admin/common.save') }}
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

@endsection
