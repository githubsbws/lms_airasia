@extends('admin.layouts.mainlayout')

@php
    $langLabel = $faq->lang === 'en' ? __('admin/faq.lang_en') : __('admin/faq.lang_th');
@endphp

@section('title', __('admin/faq.edit_title', ['lang' => $langLabel]))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('admin/menuleft.home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.faq.list') }}">{{ __('admin/menuleft.faq') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('admin/faq.edit_title', ['lang' => $langLabel]) }}</li>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card">

                <div class="card-header bg-danger">
                    <h3 class="card-title text-white">
                        {{ __('admin/faq.edit_title', ['lang' => $langLabel]) }}
                    </h3>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.faq.update', $faq) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="faq_name" class="form-label">
                                {{ __('admin/faq.question_label', ['lang' => $langLabel]) }}<span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="faq_name"
                                id="faq_name"
                                class="form-control @error('faq_name') is-invalid @enderror"
                                value="{{ old('faq_name', $faq->faq_name) }}"
                                maxlength="255"
                                required>
                            @error('faq_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="answer" class="form-label">
                                {{ __('admin/faq.answer_label', ['lang' => $langLabel]) }}<span class="text-danger">*</span>
                            </label>
                            <textarea
                                name="answer"
                                id="answer"
                                rows="5"
                                class="form-control @error('answer') is-invalid @enderror"
                                required>{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('admin.faq.list') }}" class="btn btn-outline-secondary">
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
