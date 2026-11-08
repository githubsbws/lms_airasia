@extends('admin.layouts.mainlayout')

@php
    $langLabel = $howTo->lang === 'en' ? __('admin/howto.lang_en') : __('admin/howto.lang_th');
@endphp

@section('title', __('admin/howto.edit_title', ['lang' => $langLabel]))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('admin/menuleft.home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.howto.list') }}">{{ __('admin/menuleft.how_to') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('admin/howto.edit_title', ['lang' => $langLabel]) }}</li>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card">

                <div class="card-header bg-danger">
                    <h3 class="card-title text-white">
                        {{ __('admin/howto.edit_title', ['lang' => $langLabel]) }}
                    </h3>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.howto.update', $howTo) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="how_to_name" class="form-label">
                                {{ __('admin/howto.name_label', ['lang' => $langLabel]) }}<span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="how_to_name"
                                id="how_to_name"
                                class="form-control @error('how_to_name') is-invalid @enderror"
                                value="{{ old('how_to_name', $howTo->how_to_name) }}"
                                maxlength="255"
                                required>
                            @error('how_to_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">
                                {{ __('admin/howto.file_label', ['lang' => $langLabel]) }}
                            </label>

                            @if ($howTo->filename)
                                <div class="mb-2">
                                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('howto/'.$howTo->filename) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                        {{ __('admin/howto.current_file') }}
                                    </a>
                                </div>
                            @endif

                            <input
                                type="file"
                                name="file"
                                id="file"
                                class="form-control @error('file') is-invalid @enderror"
                                accept="application/pdf">
                            <div class="form-text">{{ __('admin/howto.file_hint') }}</div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
