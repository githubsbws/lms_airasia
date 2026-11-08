{{--
    แปลงมาจาก lms-airasia-html/faq.php
--}}
@extends('layouts.mainlayout')

@section('title', 'FAQ')

@section('content')

    <main class="faq-page">

        {{-- Black Title Bar --}}
        <section class="faq-title-bar">

            <div class="faq-title-container">

                <h1 class="faq-title">
                    FAQ
                </h1>

                <div class="faq-breadcrumb">
                    <a href="{{ route('home') }}">Homepage</a>
                    <span>/</span>
                    <span class="current">FAQ</span>
                </div>

            </div>

        </section>

        {{-- FAQ Content --}}
        <section class="faq-container">

            <div class="accordion" id="accordionExample">

                @forelse ($faqs as $index => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $faq->id }}">
                            <button
                                class="accordion-button @if (! $loop->first) collapsed @endif"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $faq->id }}"
                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $faq->id }}">
                                <i class="bi bi-question-circle-fill mx-2"></i> {{ $faq->faq_name }}
                            </button>
                        </h2>
                        <div
                            id="collapse{{ $faq->id }}"
                            class="accordion-collapse collapse @if ($loop->first) show @endif"
                            aria-labelledby="heading{{ $faq->id }}"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">
                        {{ __('home.faq_no_data') }}
                    </p>
                @endforelse

            </div>

        </section>

    </main>

@endsection
