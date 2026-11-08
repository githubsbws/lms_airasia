{{--
    แปลงมาจาก lms-airasia-html/how-to-use.php
--}}
@extends('layouts.mainlayout')

@section('title', 'LMS Manual')

@section('content')

    <div class="manual-page">

        {{-- Title Bar --}}
        <section class="manual-title-bar">

            <div class="manual-title-container">

                <h1 class="manual-title">
                    LMS Manual
                </h1>

                <div class="manual-breadcrumb">
                    <a href="{{ route('home') }}">Homepage</a>
                    <span>/</span>
                    <span class="current">LMS Manual</span>
                </div>

            </div>

        </section>

        {{-- Manual Content --}}
        <section class="manual-content">

            <div class="manual-cards">

                @forelse ($howTos as $howTo)
                    @if ($howTo->filename)
                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('howto/'.$howTo->filename) }}" target="_blank" class="manual-card">
                            <div class="manual-icon">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </div>
                            <p class="manual-card-title">
                                {{ $howTo->how_to_name }}
                            </p>
                        </a>
                    @else
                        <div class="manual-card disabled" aria-disabled="true" title="{{ __('home.how_to_file_unavailable') }}">
                            <div class="manual-icon">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </div>
                            <p class="manual-card-title">
                                {{ $howTo->how_to_name }}
                            </p>
                        </div>
                    @endif
                @empty
                    <p class="text-center w-100">
                        {{ __('home.how_to_no_data') }}
                    </p>
                @endforelse

            </div>

        </section>

    </div>

@endsection
