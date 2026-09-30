{{--
    แปลงมาจาก lms-airasia-html/course-exam.php
    หมายเหตุ: หน้านี้ต้นแบบไม่มี header/footer ของเว็บ (เต็มจอสำหรับดูวิดีโอ)
    จึงไม่ extend layouts.mainlayout แต่ทำเป็น standalone page พร้อมโหลด asset เอง
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Course Exam | {{ config('app.name', 'ETS') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
</head>
<body>

<main class="exam-page">

    {{-- Top Bar --}}
    <div class="exam-topbar">

        <a href="{{ route('course.detail') }}" class="exam-back">
            <i class="bi bi-house-fill"></i>
            Back
        </a>

        <div class="exam-page-title">
            TAX - Fatigue Management (FM)
        </div>

        <button
            type="button"
            class="exam-menu"
            id="menuButton"
            aria-label="Open course menu"
            aria-expanded="false">
            <i class="bi bi-list"></i>
        </button>

    </div>

    {{-- Main --}}
    <div class="exam-main">

        {{-- Video --}}
        <section class="exam-video-area">

            <div class="exam-video-title">
                1. TCAR Regulatory Requirements.mp4
            </div>

            <div class="video-wrapper">

                <img src="{{ asset('frontend/images/courses/video.png') }}" alt="Course Video">

                <div class="video-play-overlay">
                    <div class="video-play-button">
                        <i class="bi bi-play-fill"></i>
                    </div>
                </div>

            </div>

        </section>

        {{-- Sidebar --}}
        <aside class="exam-sidebar" id="examSidebar">

            <div class="exam-sidebar-header">
                CH 1 : TCAR Regulatory Requirements
            </div>

            @php
                $chapters = [
                    1 => ['title' => 'TCAR Regulatory Requirements', 'file' => 'TCAR Regulatory Requirements.mp4'],
                    2 => ['title' => 'Basics of Fatigue', 'file' => 'Basics of Fatigue.mp4'],
                    3 => ['title' => 'Causes of Fatigue', 'file' => 'Causes of Fatigue.mp4'],
                    4 => ['title' => 'Fatigue on Performance', 'file' => 'Fatigue on Performance.mp4'],
                    5 => ['title' => 'Fatigue Countermeasures', 'file' => 'Fatigue Countermeasures.mp4'],
                ];
            @endphp

            @foreach ($chapters as $num => $chapter)
                <div class="exam-chapter {{ $num === 1 ? 'active' : '' }}" data-chapter="{{ $num }}">

                    <div class="exam-chapter-title">
                        CH {{ $num }} : {{ $chapter['title'] }}
                    </div>

                    <div class="exam-lesson">

                        <span class="exam-lesson-radio" aria-hidden="true"></span>

                        <span class="exam-lesson-name">
                            {{ $num }}. {{ $chapter['file'] }}
                        </span>

                        <span class="exam-lesson-status">
                            Not Start
                        </span>

                    </div>

                </div>
            @endforeach

            <div class="exam-completed">
                Exam Completed
            </div>

            <div class="exam-test">
                <span class="exam-test-radio" aria-hidden="true"></span>
                <span>Test</span>
            </div>

        </aside>

    </div>

</main>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const examPage = document.querySelector(".exam-page");
    const menuButton = document.getElementById("menuButton");
    const chapters = document.querySelectorAll(".exam-chapter");
    const videoTitle = document.querySelector(".exam-video-title");
    const sidebarHeader = document.querySelector(".exam-sidebar-header");

    menuButton.addEventListener("click", function () {
        const isOpen = examPage.classList.toggle("sidebar-open");
        menuButton.setAttribute("aria-expanded", isOpen);
    });

    chapters.forEach(function (chapter) {
        chapter.addEventListener("click", function () {

            chapters.forEach(function (item) {
                item.classList.remove("active");
            });

            this.classList.add("active");

            const lesson = this.querySelector(".exam-lesson-name");

            if (lesson && videoTitle) {
                videoTitle.textContent = lesson.textContent.trim();
            }

            const chapterTitle = this.querySelector(".exam-chapter-title");

            if (chapterTitle && sidebarHeader) {
                sidebarHeader.textContent = chapterTitle.textContent.trim();
            }

        });
    });

});
</script>

</body>
</html>
