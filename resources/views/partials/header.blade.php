{{-- =========================================================
| Header: ฝั่ง User (หน้าบ้าน)
| แปลงมาจาก lms-airasia-html/includes/header.php
| ใช้ร่วมกับ resources/views/layouts/mainlayout.blade.php
========================================================== --}}
<nav class="navmain navbar navbar-expand-lg navbar-light bg-light">

    <div class="container-fluid">

        {{-- Logo --}}
        <a class="navbar-brand" href="{{ route('home') }}">
            <img
                src="{{ asset('frontend/images/logo.png') }}"
                class="logonav"
                alt="AirAsia e-Learning">
        </a>

        {{-- Mobile Menu Button --}}
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            {{-- Menu --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('course.*') ? 'active' : '' }}"
                        href="{{ route('course.index') }}">
                        Course
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('how-to-use') ? 'active' : '' }}"
                        href="{{ route('how-to-use') }}">
                        How to use
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}"
                        href="{{ route('faq') }}">
                        FAQ
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">
                        Contact us
                    </a>
                </li>

            </ul>

            {{-- Username --}}
            <form class="d-flex">

                <button type="button" class="btn btn-primary">

                    <span>{{ auth()->user()->name ?? 'Username' }}</span>

                    <img
                        src="{{ asset('frontend/images/users/user-1.png') }}"
                        class="logouser rounded-circle"
                        alt="">

                </button>

            </form>

        </div>
    </div>
</nav>
