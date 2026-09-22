{{--
    แปลงมาจาก lms-airasia-html/course-detail.php
--}}
@extends('layouts.mainlayout')

@section('title', 'Course Detail')

@section('content')

    {{-- Page Title / Breadcrumb --}}
    <section class="detail-page-banner">

        <div class="detail-title-container">

            <div class="detail-title-wrapper">

                <h1 class="detail-title">
                    TAX - Fatigue Management (FM)
                </h1>

                <p class="detail-period">
                    Period 0 day (7 Sep. / 2026 - 13 Sep. / 2026)
                </p>

            </div>

            <div class="detail-breadcrumb">
                <a href="{{ route('home') }}">Homepage</a>
                <span>/</span>
                <a href="{{ route('course.index') }}">Course</a>
                <span>/</span>
                <span class="current">Course Name</span>
            </div>

        </div>

    </section>

    {{-- Course Detail Content --}}
    <main class="detail-content">

        <div class="detail-container">

            {{-- Status --}}
            <section class="status-box">

                <div class="status-header">
                    <span>Status</span>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

                <div class="status-body">

                    <div class="status-item">
                        <div class="status-name">All Lesson Completed</div>
                        <div class="status-image-wrapper">
                            <img src="{{ asset('frontend/images/exam/status1.png') }}" alt="All Lesson Completed" class="status-image">
                            <span class="status-number">1</span>
                        </div>
                    </div>

                    <div class="status-item">
                        <div class="status-name">Exam Completed</div>
                        <div class="status-image-wrapper">
                            <img src="{{ asset('frontend/images/exam/status2.png') }}" alt="Exam Completed" class="status-image">
                            <span class="status-number">2</span>
                        </div>
                    </div>

                    <div class="status-item">
                        <div class="status-name">Training Feedback Given</div>
                        <div class="status-image-wrapper">
                            <img src="{{ asset('frontend/images/exam/status3.png') }}" alt="Training Feedback Given" class="status-image">
                            <span class="status-number">3</span>
                        </div>
                    </div>

                    <div class="status-item">
                        <div class="status-name">Not Pass</div>
                        <div class="status-image-wrapper">
                            <img src="{{ asset('frontend/images/exam/no_pass.png') }}" alt="Not Pass" class="status-image">
                            <span class="status-number" style="background-color: #ed1c24; color: #fff; font-size: 0;">&times;</span>
                        </div>
                    </div>

                </div>

            </section>

            {{-- Tabs --}}
            <section class="detail-tabs">
                <button type="button" class="detail-tab active" data-tab="details">
                    Details
                </button>
                <button type="button" class="detail-tab" data-tab="course-content">
                    The content of this course.
                </button>
            </section>

            {{-- Tab Content --}}
            <div class="detail-tab-content">

                <div class="tab-panel active" id="details">
                    <p>TAX - Fatigue Management (FM)</p>
                </div>

                <div class="tab-panel" id="course-content">

                    <div class="course-outline">

                        @php
                            $chapters = [
                                1 => ['title' => 'TCAR Regulatory Requirements', 'file' => 'TCAR Regulatory Requirements.mp4', 'status' => 'in-progress'],
                                2 => ['title' => 'Basics of Fatigue', 'file' => 'Basics of Fatigue.mp4', 'status' => null],
                                3 => ['title' => 'Causes of Fatigue', 'file' => 'Causes of Fatigue.mp4', 'status' => null],
                                4 => ['title' => 'Fatigue on Performance', 'file' => 'Fatigue on Performance.mp4', 'status' => null],
                                5 => ['title' => 'Fatigue Countermeasures', 'file' => 'Fatigue Countermeasures.mp4', 'status' => null],
                            ];
                        @endphp

                        @foreach ($chapters as $num => $chapter)
                            <div class="chapter {{ $num === 1 ? 'open' : '' }}" data-chapter="{{ $num }}">

                                <div class="chapter-header">

                                    <img
                                        src="{{ asset('frontend/images/courses/this-course.png') }}"
                                        alt="AirAsia"
                                        class="chapter-logo">

                                    <span class="chapter-name">
                                        CH {{ $num }} : {{ $chapter['title'] }}
                                    </span>

                                    <span class="chapter-status {{ $chapter['status'] ? 'in-progress' : '' }}">
                                        {{ $chapter['status'] ? 'In Progress' : 'Not Start' }}
                                    </span>

                                    <i class="fa-solid fa-chevron-down chapter-arrow"></i>

                                </div>

                                <div class="chapter-body">

                                    <div class="chapter-part">
                                        <span>Part 1 Start</span>
                                        <span class="chapter-here">You are here</span>
                                    </div>

                                    <div class="chapter-lesson">

                                        <span class="lesson-number">1.</span>

                                        <span class="lesson-name">
                                            {{ $chapter['file'] }}
                                        </span>

                                        <span class="lesson-status">
                                            Not Start
                                        </span>

                                        <a href="{{ route('course.exam') }}" class="lesson-start">
                                            Start
                                            <i class="fa-solid fa-circle-play"></i>
                                        </a>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                        {{-- Exam --}}
                        <div class="course-exam">

                            <div class="exam-header">
                                TAX - Fatigue Management (FM) Exam
                            </div>

                            <div class="exam-body">

                                <span class="exam-name">
                                    Final Test Times 1
                                </span>

                                <a href="{{ route('exam.final') }}" class="exam-button">
                                    Start
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    /* =========================================================
       TABS
    ========================================================= */
    const tabs = document.querySelectorAll(".detail-tab");
    const panels = document.querySelectorAll(".tab-panel");

    tabs.forEach(function (tab) {
        tab.addEventListener("click", function () {

            const target = this.dataset.tab;

            tabs.forEach(function (item) {
                item.classList.remove("active");
            });

            panels.forEach(function (panel) {
                panel.classList.remove("active");
            });

            this.classList.add("active");

            const targetPanel = document.getElementById(target);

            if (targetPanel) {
                targetPanel.classList.add("active");
            }

        });
    });

    /* =========================================================
       CHAPTER ACCORDION
    ========================================================= */
    const chapters = document.querySelectorAll(".chapter");

    chapters.forEach(function (chapter) {

        const header = chapter.querySelector(".chapter-header");
        const here = chapter.querySelector(".chapter-here");

        header.addEventListener("click", function () {

            chapters.forEach(function (item) {
                item.classList.remove("open");

                const itemHere = item.querySelector(".chapter-here");

                if (itemHere) {
                    itemHere.style.display = "none";
                }
            });

            chapter.classList.add("open");

            if (here) {
                here.style.display = "block";
            }

        });

    });

});
</script>
@endpush
