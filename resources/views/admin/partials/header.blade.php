{{-- =========================================================
| Header (Topbar): ฝั่ง Admin (AdminLTE v4)
| ใช้ร่วมกับ resources/views/admin/layouts/mainlayout.blade.php
========================================================== --}}
<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">

        {{-- Sidebar Toggle --}}
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>

        {{-- Right --}}
        <ul class="navbar-nav ms-auto">

            {{-- Language Switcher --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="admin-language-menu" data-bs-toggle="dropdown"
                    aria-expanded="false" aria-label="Change language">
                    <i class="bi bi-translate"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="admin-language-menu">
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'th' ? 'active' : '' }}" href="{{ route('lang.switch', 'th') }}">
                            TH
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">
                            EN
                        </a>
                    </li>
                </ul>
            </li>

            {{-- User Menu --}}
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="d-none d-md-inline me-1">{{ auth()->user()->username ?? '' }}</span>
                    <i class="bi bi-person-circle fs-5"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('home') }}">
                            <i class="bi bi-box-arrow-left me-2"></i>
                            {{ __('admin/menuleft.home') }} ({{ config('app.name', 'ETS') }})
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                {{ __('auth.logout') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </li>

        </ul>

    </div>
</nav>
