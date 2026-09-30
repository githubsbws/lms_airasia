{{--
    แปลงมาจาก lms-airasia-html/course.php
--}}
@extends('layouts.mainlayout')

@section('title', 'Course')

@push('styles')
<style>
    /* ให้ Content ขยายพื้นที่ที่เหลือ
        เพื่อดัน Footer ลงล่างสุด */
    .course-content {
        flex: 1;
    }

    .course-page-banner {
        width: 100%;
        background-color: #191919;
        min-height: 62px;
    }

    .course-title-container {
        max-width: 1200px;
        margin: 0 auto;
        min-height: 62px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0;
    }

    .course-title {
        margin: 0;
        color: #fff;
        font-size: 20px;
        font-weight: 400;
        line-height: 1.2;
    }

    .course-breadcrumb {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 13px;
        color: #999;
        white-space: nowrap;
    }

    .course-breadcrumb .current {
        color: #fff;
        text-decoration: none;
    }

    .course-content {
        width: 100%;
        background-color: #fff;
        padding: 40px 0 50px;
        min-height: 450px;
    }

    .course-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .course-layout {
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }

    .course-sidebar {
        width: 160px;
        flex-shrink: 0;
    }

    .course-search {
        display: flex;
        width: 100%;
        margin-bottom: 11px;
    }

    .course-search input {
        width: calc(100% - 32px);
        height: 29px;
        border: 1px solid #d2d2d2;
        border-right: none;
        border-radius: 4px 0 0 4px;
        padding: 4px 8px;
        font-family: inherit;
        font-size: 12px;
        color: #555;
        outline: none;
    }

    .course-search input:focus {
        border-color: #aaa;
    }

    .course-search button {
        width: 32px;
        height: 29px;
        border: none;
        border-radius: 0 4px 4px 0;
        background-color: #050505;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 13px;
        transition: background-color 0.2s ease;
    }

    .course-search button:hover {
        background-color: #ed1c24;
    }

    .course-category-title {
        width: 100%;
        height: 32px;
        background-color: #191919;
        color: #fff;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .course-filter {
        width: 100%;
        height: 32px;
        background-color: #eeeeee;
        border: 1px solid #d8d8d8;
        border-radius: 4px;
        color: #333;
        font-family: inherit;
        font-size: 14px;
        cursor: pointer;
        margin-bottom: 5px;
        padding: 4px 8px;
        transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    .course-filter:hover {
        background-color: #ddd;
    }

    .course-filter.active {
        background-color: #dedede;
        border-color: #c5c5c5;
        color: #000;
        font-weight: 500;
    }

    .course-list {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(4, 230px);
        gap: 20px;
        align-items: start;
    }

    .course-card {
        width: 160px;
        min-height: 190px;
        background-color: #eeeeee;
        border-radius: 6px;
        padding: 10px;
        text-align: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .course-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
    }

    .course-image-link {
        display: block;
        text-decoration: none;
    }

    .course-image {
        width: 140px;
        height: 95px;
        object-fit: cover;
        border-radius: 7px;
        display: block;
        margin: 0 auto 10px;
    }

    .course-name {
        display: block;
        color: #ed1c24;
        font-size: 15px;
        font-weight: 500;
        line-height: 1.3;
        text-decoration: none;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 10px;
    }

    .course-name:hover {
        color: #c81017;
        text-decoration: underline;
    }

    .course-description {
        margin: 0;
        color: #555;
        font-size: 12px;
        line-height: 1.45;
    }

    .no-course {
        display: none;
        flex: 1;
        padding: 35px 10px;
        text-align: center;
        color: #888;
        font-size: 14px;
    }

    @media (max-width: 991.98px) {
        .course-title-container,
        .course-container {
            max-width: 90%;
        }

        .course-list {
            grid-template-columns: repeat(3, 160px);
            gap: 15px;
        }
    }

    @media (max-width: 767.98px) {
        .course-title-container {
            width: 100%;
            max-width: 90%;
            min-height: auto;
            flex-direction: column;
            align-items: flex-start;
            padding-top: 16px;
            padding-bottom: 16px;
            gap: 8px;
        }

        .course-breadcrumb {
            width: 100%;
            justify-content: flex-start;
        }

        .course-layout {
            flex-direction: column;
            width: 100%;
            gap: 25px;
        }

        .course-sidebar {
            width: 100%;
            max-width: none;
        }

        .course-search {
            width: 100%;
            max-width: none;
        }

        .course-category-title {
            width: 100%;
            max-width: none;
        }

        .course-filter {
            width: 100%;
            max-width: none;
        }

        .course-list {
            width: 100%;
            grid-template-columns: repeat(2, 160px);
            justify-content: center;
            gap: 15px;
        }

        .no-course {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .course-title-container,
        .course-container {
            max-width: 92%;
        }

        .course-title-container {
            padding: 15px;
        }

        .course-title {
            font-size: 19px;
        }

        .course-breadcrumb {
            font-size: 12px;
            gap: 8px;
        }

        .course-list {
            grid-template-columns: repeat(2, 145px);
            gap: 12px;
        }

        .course-card {
            width: 145px;
        }

        .course-image {
            width: 125px;
            height: 90px;
        }

        .course-name {
            font-size: 14px;
        }

        .course-description {
            font-size: 11px;
        }
    }

    @media (max-width: 360px) {
        .course-title-container,
        .course-container {
            max-width: 94%;
        }

        .course-title-container {
            padding: 14px;
            gap: 6px;
        }

        .course-title {
            font-size: 19px;
        }

        .course-breadcrumb {
            font-size: 11px;
            gap: 7px;
        }

        .course-list {
            grid-template-columns: 1fr;
            justify-items: center;
        }
    }
</style>
@endpush

@section('content')

    {{-- Page Title / Breadcrumb --}}
    <section class="course-page-banner">

        <div class="course-title-container">

            <h1 class="course-title">
                Course
            </h1>

            <div class="course-breadcrumb">
                <span>Homepage</span>
                <span>/</span>
                <span class="current">Course</span>
            </div>

        </div>

    </section>

    {{-- Course Content --}}
    <main class="course-content">

        <div class="course-container">

            <div class="course-layout">

                {{-- Sidebar --}}
                <aside class="course-sidebar">

                    <div class="course-search">
                        <input type="text" id="courseSearch" placeholder="Enter text to search for.">
                        <button type="button" id="searchButton" aria-label="Search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>

                    <div class="course-category-title">
                        Course Category
                    </div>

                    <button type="button" class="course-filter active" data-category="all">
                        All Courses
                    </button>

                    <button type="button" class="course-filter" data-category="staff">
                        e-Learning for Staff
                    </button>

                </aside>

                {{-- Course List --}}
                <section class="course-list" id="courseList">

                    <div class="course-card" data-category="staff" data-name="e-Learning for Staff">
                        <a href="{{ route('course.detail') }}" class="course-image-link">
                            <img src="{{ asset('frontend/images/courses/e-learning.png') }}" alt="e-Learning for Staff" class="course-image">
                        </a>
                        <a href="{{ route('course.detail') }}" class="course-name" title="e-Learning for Staff">
                            e-Learning for Staff
                        </a>
                        <p class="course-description">
                            TAA/TAX/AASEA และอื่นๆ
                        </p>
                    </div>

                    @for ($i = 1; $i <= 5; $i++)
                        <div class="course-card" data-category="general" data-name="Course {{ $i }}">
                            <a href="#" class="course-image-link">
                                <img src="{{ asset('frontend/images/courses/course-' . $i . '.png') }}" alt="Course {{ $i }}" class="course-image">
                            </a>
                            <a href="#" class="course-name" title="Course {{ $i }}">
                                Course {{ $i }}
                            </a>
                            <p class="course-description">
                                General E-Learning
                            </p>
                        </div>
                    @endfor

                </section>

                <div class="no-course" id="noCourse">
                    No course found.
                </div>

            </div>

        </div>

    </main>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const filterButtons = document.querySelectorAll(".course-filter");
        const courseCards = document.querySelectorAll(".course-card");
        const searchInput = document.getElementById("courseSearch");
        const searchButton = document.getElementById("searchButton");
        const noCourse = document.getElementById("noCourse");

        let currentCategory = "all";

        function filterCourses() {

            const keyword = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            courseCards.forEach(function(card) {

                const category = card.dataset.category;
                const name = card.dataset.name.toLowerCase();

                const categoryMatch = currentCategory === "all" || category === currentCategory;
                const searchMatch = keyword === "" || name.includes(keyword);

                if (categoryMatch && searchMatch) {
                    card.style.display = "";
                    visibleCount++;
                } else {
                    card.style.display = "none";
                }

            });

            noCourse.style.display = visibleCount === 0 ? "block" : "none";

        }

        filterButtons.forEach(function(button) {

            button.addEventListener("click", function() {

                filterButtons.forEach(function(btn) {
                    btn.classList.remove("active");
                });

                this.classList.add("active");

                currentCategory = this.dataset.category;

                filterCourses();

            });

        });

        searchInput.addEventListener("input", filterCourses);
        searchButton.addEventListener("click", filterCourses);

        filterCourses();

    });
</script>
@endpush
