{{--
    แปลงมาจาก lms-airasia-html/final-exam.php
--}}
@extends('layouts.mainlayout')

@section('title', 'Final Exam')

@section('content')

    {{-- Page Title (ตำแหน่งเดียวกับ Course Detail) --}}
    <section class="detail-page-banner">
        <div class="detail-title-container">
            <h1 class="detail-title">
                TAX - Fatigue Management (FM)
            </h1>
        </div>
    </section>

    {{-- Exam Detail --}}
    <main class="exam-content">

        <section class="exam-detail-box">

            <h2 class="exam-detail-title">
                Course Examination
            </h2>

            <p class="exam-course-name">
                Course Name : TAX - Fatigue Management (FM)
            </p>

            <hr class="exam-divider">

            <div class="exam-info">

                <div class="exam-info-row">
                    <span class="exam-info-label">Number of questions</span>
                    <span class="exam-info-value">20 Questions</span>
                </div>

                <div class="exam-info-row">
                    <span class="exam-info-label">Time allowed</span>
                    <span class="exam-info-value">60 Minutes</span>
                </div>

                <div class="exam-info-row">
                    <span class="exam-info-label">Total score</span>
                    <span class="exam-info-value">20 Points</span>
                </div>

            </div>

            <div class="exam-test-wrapper">
                <a href="{{ route('exam.test') }}" class="exam-test-button">
                    Test
                </a>
            </div>

        </section>

    </main>

@endsection
