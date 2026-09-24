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
                        {{ __('home.home') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('course.*') ? 'active' : '' }}"
                        href="{{ route('course.index') }}">
                        {{ __('home.course') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('how-to-use') ? 'active' : '' }}"
                        href="{{ route('how-to-use') }}">
                        {{ __('home.how_to_use') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}"
                        href="{{ route('faq') }}">
                        {{ __('home.faq') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">
                        {{ __('home.contact') }}
                    </a>
                </li>

            </ul>

            {{-- Language Switcher --}}
            <div class="btn-group me-3" role="group" aria-label="Language switcher">
                <a
                    href="{{ route('lang.switch', 'th') }}"
                    class="btn btn-sm {{ app()->getLocale() === 'th' ? 'btn-dark' : 'btn-outline-dark' }}">
                    TH
                </a>
                <a
                    href="{{ route('lang.switch', 'en') }}"
                    class="btn btn-sm {{ app()->getLocale() === 'en' ? 'btn-dark' : 'btn-outline-dark' }}">
                    EN
                </a>
            </div>

            @auth
                {{-- Username (login แล้ว) --}}
                <div class="dropdown">

                    <button
                        type="button"
                        class="btn btn-primary dropdown-toggle"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        <span>{{ auth()->user()->username }}</span>

                        <img
                            src="{{ asset('frontend/images/users/user-1.png') }}"
                            class="logouser rounded-circle"
                            alt="">

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        @if ((int) auth()->user()->superuser === 1)
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.home') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>
                                    Admin
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                        @endif

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    {{ __('auth.logout') }}
                                </button>
                            </form>
                        </li>

                    </ul>

                </div>
            @else
                {{-- ปุ่ม Login (guest) — เปิด Modal --}}
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#loginModal">

                    <span>{{ __('auth.login') }}</span>

                </button>
            @endauth

        </div>
    </div>
</nav>
