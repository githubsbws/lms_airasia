{{--
    แปลงมาจาก lms-airasia-html/result.php
--}}
@extends('layouts.mainlayout')

@section('title', 'Result')

@section('content')

    {{-- Page Title --}}
    <section class="result-page-banner">

        <div class="result-title-container">

            <h1 class="result-title">
                Result
            </h1>

            <div class="result-breadcrumb">
                <a href="{{ route('home') }}">Homepage</a> / Result
            </div>

        </div>

    </section>

    {{-- Result --}}
    <main class="result-content">

        <div class="result-container">

            {{-- Left --}}
            <div class="result-left">

                <div class="result-green-box">

                    <div class="result-status" id="resultStatus">

                        <i id="resultStatusIcon" class="fa-solid"></i>

                        <div class="result-status-text" id="resultStatusText">
                            Loading...
                        </div>

                    </div>

                    <div class="result-summary">

                        <div class="summary-row">
                            <span class="summary-label">Number of questions</span>
                            <span class="summary-value" id="totalQuestions">20 Questions</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Total Time</span>
                            <span class="summary-value" id="totalTime">60 minutes</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Time spent</span>
                            <span class="summary-value" id="timeSpent">0 minutes</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Total score</span>
                            <span class="summary-value" id="totalScore">20 points</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Score earned</span>
                            <span class="summary-value bold" id="scoreEarned">0 points</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Percent</span>
                            <span class="summary-value bold" id="percentage">0.00 %</span>
                        </div>

                    </div>

                </div>

                <button
                    type="button"
                    class="completed-button"
                    onclick="window.location.href='{{ route('home') }}'">
                    Completed
                </button>

            </div>

            {{-- Score --}}
            <div class="score-panel">

                <div class="score-title">
                    <span>Score</span>
                    <span class="score-number" id="scoreNumber">0</span>
                </div>

                <div class="question-result-list" id="questionResultList"></div>

            </div>

        </div>

    </main>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const storedResult = localStorage.getItem("taxFatigueExamResult");

    if (!storedResult) {
        document.getElementById("resultStatusText").textContent = "No Result";
        return;
    }

    const result = JSON.parse(storedResult);

    const score = Number(result.score);
    const totalQuestions = Number(result.totalQuestions);
    const percentage = Number(result.percentage);

    /*
     * กำหนดคะแนนผ่าน 50%
     */
    const passPercentage = 50;
    const passed = percentage >= passPercentage;

    const statusBox = document.getElementById("resultStatus");
    const statusIcon = document.getElementById("resultStatusIcon");
    const statusText = document.getElementById("resultStatusText");

    statusBox.classList.add(passed ? "passed" : "failed");

    if (passed) {
        statusIcon.outerHTML = '<i id="resultStatusIcon" class="fa-solid fa-circle-check"></i>';
        statusText.textContent = "Passed";
    } else {
        statusIcon.outerHTML = '<i id="resultStatusIcon" class="fa-solid fa-circle-xmark"></i>';
        statusText.textContent = "Failed";
    }

    document.getElementById("totalQuestions").textContent = totalQuestions + " Questions";
    document.getElementById("totalTime").textContent = formatMinutes(result.totalTime);
    document.getElementById("timeSpent").textContent = formatMinutes(result.timeSpent);
    document.getElementById("totalScore").textContent = totalQuestions + " points";
    document.getElementById("scoreEarned").textContent = score + " points";
    document.getElementById("percentage").textContent = percentage.toFixed(2) + " %";
    document.getElementById("scoreNumber").textContent = score;

    const resultList = document.getElementById("questionResultList");
    resultList.innerHTML = "";

    result.questions.forEach(function (question, index) {

        const userAnswer = result.answers[index];
        const isCorrect = Number(userAnswer) === Number(question.correct);

        const row = document.createElement("div");
        row.className = "question-result";

        const dot = document.createElement("span");
        dot.className = "result-dot " + (isCorrect ? "correct" : "wrong");

        const label = document.createElement("span");
        label.textContent = "question " + (index + 1);

        const questionScore = document.createElement("span");
        questionScore.className = "question-score";
        questionScore.textContent = isCorrect ? "1" : "0";

        row.appendChild(dot);
        row.appendChild(label);
        row.appendChild(questionScore);

        resultList.appendChild(row);

    });

});

function formatMinutes(seconds) {

    const minutes = Math.floor(Number(seconds) / 60);

    if (minutes < 1) {
        return "< 1 minute";
    }

    return minutes + " minutes";

}
</script>
@endpush
