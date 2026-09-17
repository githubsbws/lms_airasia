{{--
    แปลงมาจาก lms-airasia-html/index.php
--}}
@extends('layouts.mainlayout')

@section('title', 'Home')

@section('content')

    {{-- =========================================================
         Hero Banner
    ========================================================== --}}
    <section class="hero-banner">

        <img
            src="{{ asset('frontend/images/banner2022.jpg') }}"
            alt="AirAsia E-Learning Banner">

        <div class="hero-overlay"></div>

        {{-- <div class="hero-content">
            <div>
                <h1 class="hero-title">
                    E-Learning System
                    <span class="airasia-text">
                        airasia
                    </span>
                </h1>
            </div>
        </div> --}}

    </section>


    {{-- =========================================================
         Course Section
    ========================================================== --}}
    <main class="main-content">

        <div class="content-wrapper">

            {{-- Course Header --}}
            <div class="section-header">
                <h2 class="section-title">
                    Course
                </h2>

                <a href="{{ route('course.index') }}" class="view-btn">
                    View
                </a>
            </div>

            {{-- Course Area --}}
            <div class="course-area">

                {{-- Label --}}
                <div class="course-label-wrapper">
                    <div class="course-label">
                        e-Learning for staff
                    </div>
                </div>

                {{-- Course Card --}}
                <div class="course-card">
                    <a href="{{ route('course.detail') }}">

                        <img
                            src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80"
                            alt="E-Learning Course"
                            class="course-image">

                        <div class="course-body">

                            <div class="course-name">
                                TAX - Fatique
                                <br>
                                Management (FM)
                            </div>

                            <div class="course-description">
                                TAX - Fatique Management (FM)
                            </div>

                            <div class="course-date">
                                <i class="bi bi-calendar-event"></i>
                                16 Mar. 2026, 16:36
                            </div>

                        </div>
                    </a>
                </div>

            </div>

        </div>

    </main>


    {{-- =========================================================
         Documents
    ========================================================== --}}
    <section class="documents-section">

        <div class="content-wrapper">

            {{-- Documents Header --}}
            <div class="section-header">
                <h2 class="section-title">
                    Documents
                </h2>

                <a href="{{ route('document.index') }}" class="view-btn">
                    View
                </a>
            </div>

            {{-- Document --}}
            <div class="document-box">

                <div class="document-text">
                    Link: แจ้งปัญหาการเรียน SilverCare
                    (eLearning)
                    https://forms.gle/Gen7DrfP9MYKuu8
                </div>

                <div class="document-actions">

                    <div class="document-date">
                        <i class="bi bi-calendar-event"></i>
                        8 Jul. 2026, 16:31
                    </div>

                    <a href="#" class="download-btn">
                        <i class="bi bi-download"></i>
                        Download
                    </a>

                </div>

            </div>

        </div>

    </section>

@endsection
