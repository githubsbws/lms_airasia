{{--
    แปลงมาจาก lms-airasia-html/exam.php
--}}
@extends('layouts.mainlayout')

@section('title', 'Course Exam')

@push('styles')
<style>
    .detail-page-banner {
        width: 100%;
        background-color: #191919;
        min-height: 55px;
    }

    .detail-title-container {
        max-width: 775px;
        margin: 0 auto;
        min-height: 55px;
        display: flex;
        align-items: center;
        padding: 0;
    }

    .detail-title {
        margin: 0;
        color: #fff;
        font-size: 20px;
        font-weight: 400;
        line-height: 1.2;
    }

    .exam-page-content {
        flex: 1;
        width: 100%;
        background-color: #fff;
        padding: 44px 0 58px;
    }

    .exam-container {
        width: 100%;
        max-width: 775px;
        margin: 0 auto;
    }

    .exam-timer {
        width: 100%;
        min-height: 57px;
        margin-bottom: 21px;
        background-color: #f1dada;
        border-radius: 4px;
        box-shadow: 3px 3px 4px rgba(0, 0, 0, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b64b4b;
        font-size: 17px;
        font-weight: 600;
    }

    .exam-timer.warning { color: #d17d10; }
    .exam-timer.danger { color: #ed1c24; }

    .exam-box {
        width: 100%;
        min-height: 270px;
        background-color: #e7e7e7;
        border-radius: 5px;
        border-left: 12px solid #4c8c43;
        border-right: 12px solid #4c8c43;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
        padding: 0 8px 10px;
    }

    .exam-top {
        width: 100%;
        min-height: 47px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
    }

    .question-area {
        flex: 1;
        min-width: 0;
        padding: 5px 0 0;
    }

    .question-number-title {
        margin: 0 0 8px;
        color: #333;
        font-size: 15px;
        font-weight: 600;
        line-height: 1.4;
    }

    .question-text {
        margin: 0;
        color: #333;
        font-size: 15px;
        font-weight: 400;
        line-height: 1.5;
    }

    .question-navigation {
        width: 245px;
        flex-shrink: 0;
    }

    .navigation-title {
        height: 29px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #777;
        color: #666;
        font-size: 13px;
        font-weight: 500;
    }

    .navigation-count {
        color: #555;
        font-size: 13px;
        font-weight: 600;
    }

    .question-grid {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        border-left: 1px solid #d0d0d0;
        border-top: 1px solid #d0d0d0;
    }

    .question-number {
        height: 28px;
        padding: 0;
        border: none;
        border-right: 1px solid #d0d0d0;
        border-bottom: 1px solid #d0d0d0;
        background-color: #fff;
        color: #555;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        line-height: 28px;
        text-align: center;
        cursor: pointer;
        transition: 0.15s ease;
    }

    .question-number:hover { filter: brightness(0.95); }
    .question-number.current { background-color: #ed1c24; color: #fff; }
    .question-number.unvisited { background-color: #fff; color: #555; }
    .question-number.answered { background-color: #5cb85c; color: #fff; }

    .answers-box {
        width: 65%;
        min-height: 145px;
        margin-top: 10px;
        margin-bottom: 13px;
        padding: 14px 15px;
        background-color: #eaeaea;
        border: 1px solid #dedede;
        border-radius: 5px;
    }

    .answer-option {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        width: 100%;
        margin-bottom: 13px;
        cursor: pointer;
        color: #333;
        font-size: 14px;
        line-height: 1.4;
    }

    .answer-option:last-child { margin-bottom: 0; }

    .answer-option input {
        width: 14px;
        height: 14px;
        margin-top: 3px;
        flex-shrink: 0;
        accent-color: #777;
    }

    .answer-option label { cursor: pointer; flex: 1; }

    .exam-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 4px;
        width: 100%;
    }

    .exam-button {
        min-width: 62px;
        height: 32px;
        padding: 4px 14px;
        border: none;
        border-radius: 4px;
        color: #fff;
        font-family: inherit;
        font-size: 13px;
        line-height: 1;
        cursor: pointer;
        transition: 0.15s ease;
    }

    .previous-button, .next-button { background-color: #ed1c24; }
    .previous-button:hover, .next-button:hover { background-color: #c9151c; }

    .send-button {
        min-width: 70px;
        height: 32px;
        background-color: #5cb85c;
        display: none !important;
    }

    .send-button:hover { background-color: #449d44; }

    .send-button.show {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
    }

    .exam-button:disabled { opacity: 0.45; cursor: not-allowed; }

    @media (max-width: 991.98px) {
        .detail-title-container, .exam-container { width: 90%; }
        .answers-box { width: 70%; }
    }

    @media (max-width: 767.98px) {
        .detail-page-banner { min-height: 65px; }
        .detail-title-container { min-height: 65px; }
        .detail-title { font-size: 19px; }
        .exam-page-content { padding: 30px 0 50px; }
        .exam-timer { min-height: 52px; margin-bottom: 15px; font-size: 16px; }
        .exam-box { border-left-width: 8px; border-right-width: 8px; padding: 0 7px 12px; }
        .exam-top { flex-direction: column; gap: 8px; }
        .question-area { width: 100%; }
        .question-navigation { width: 100%; }
        .navigation-title { height: 29px; }
        .question-grid { grid-template-columns: repeat(10, 1fr); }
        .question-number { height: 32px; line-height: 32px; font-size: 13px; }
        .answers-box { width: 100%; min-height: 0; margin-top: 10px; padding: 14px; }
        .answer-option { font-size: 14px; }
        .exam-buttons { margin-top: 5px; flex-wrap: wrap; }
    }

    @media (max-width: 480px) {
        .detail-title-container, .exam-container { width: 92%; }
        .detail-title { font-size: 18px; }
        .exam-page-content { padding: 25px 0 40px; }
        .exam-timer { font-size: 15px; }
        .question-number-title { font-size: 14px; }
        .question-text { font-size: 13px; }
        .answer-option { font-size: 13px; margin-bottom: 11px; }
        .exam-button { font-size: 12px; min-width: 58px; height: 31px; }
    }

    @media (max-width: 360px) {
        .detail-title-container, .exam-container { width: 94%; }
        .question-number { font-size: 11px; }
        .answer-option { font-size: 12px; }
    }
</style>
@endpush

@section('content')

    {{-- Page Title --}}
    <section class="detail-page-banner">
        <div class="detail-title-container">
            <h1 class="detail-title">
                TAX - Fatigue Management (FM)
            </h1>
        </div>
    </section>

    {{-- Exam Content --}}
    <main class="exam-page-content">

        <div class="exam-container">

            {{-- Timer --}}
            <div class="exam-timer" id="examTimer">
                Time : 01:00:00
            </div>

            {{-- Exam Box --}}
            <section class="exam-box">

                <div class="exam-top">

                    <div class="question-area">

                        <div class="question-number-title" id="questionNumberTitle">
                            1. ข้อสอบ
                        </div>

                        <p class="question-text" id="questionText">
                            Loading question...
                        </p>

                    </div>

                    <div class="question-navigation">

                        <div class="navigation-title">
                            <span>การทำข้อสอบ</span>
                            <span class="navigation-count" id="navigationCount">0 / 20</span>
                        </div>

                        <div class="question-grid" id="questionGrid"></div>

                    </div>

                </div>

                <div class="answers-box" id="answersBox"></div>

                <div class="exam-buttons">

                    <button type="button" class="exam-button previous-button" id="previousButton">
                        Previous
                    </button>

                    <button type="button" class="exam-button next-button" id="nextButton">
                        Next
                    </button>

                    <button type="button" class="exam-button send-button" id="sendButton">
                        send
                    </button>

                </div>

            </section>

        </div>

    </main>

@endsection

@push('scripts')
<script src="{{ asset('frontend/js/exam.js') }}"></script>
@endpush
