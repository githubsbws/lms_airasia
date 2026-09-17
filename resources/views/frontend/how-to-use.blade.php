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

                {{-- Admin Manual --}}
                <a href="#" class="manual-card">
                    <div class="manual-icon">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <p class="manual-card-title">
                        สำหรับผู้ดูแลระบบ
                    </p>
                </a>

                {{-- User Manual --}}
                <a href="#" class="manual-card">
                    <div class="manual-icon">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <p class="manual-card-title">
                        สำหรับผู้ใช้งานทั่วไป
                    </p>
                </a>

            </div>

        </section>

    </div>

@endsection
