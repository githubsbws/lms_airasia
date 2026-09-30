{{--
    แปลงมาจาก lms-airasia-html/document.php
--}}
@extends('layouts.mainlayout')

@section('title', 'Documents')

@section('content')

    {{-- Page Banner --}}
    <section class="page-banner">

        <div class="page-banner-inner">

            <h1 class="page-title">
                Documents
            </h1>

            <div class="breadcrumb-area">
                <a href="{{ route('home') }}">Homepage</a>
                <span class="separator">/</span>
                <span class="current">Documents</span>
            </div>

        </div>

    </section>

    {{-- Documents Content --}}
    <div class="documents-main">

        <div class="content-wrapper">

            <div class="document-panel">

                {{-- Panel Header --}}
                <div class="document-panel-header">
                    <i class="bi bi-file-earmark-fill"></i>
                    <h2 class="document-panel-title">
                        E-learning Documents for Download
                    </h2>
                </div>

                {{-- Document Row --}}
                <div class="document-row">

                    <a
                        href="#"
                        class="document-link"
                        target="_blank"
                        rel="noopener noreferrer">
                        Link: แจ้งปัญหาการเรียน SilverCare (eLearning)
                        https://forms.gle/Gen7DrfP9MYKuu8
                    </a>

                    <div class="document-actions">

                        <div class="document-date">
                            <i class="bi bi-calendar-event"></i>
                            8 Jul. 2026, 16:31
                        </div>

                        <a href="#" class="download-btn" target="_blank">
                            <i class="bi bi-download"></i>
                            Download
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
