/* =========================================================
   TAX - FATIGUE MANAGEMENT EXAM
   20 Questions / 60 Minutes
========================================================= */


/* =========================================================
   QUESTIONS
========================================================= */

const questions = [

    {
        question: "What does the term \"Internal Alarm Clock\" refer to in the context of circadian rhythms?",
        answers: [
            "The mechanical alarm used by crew members during in-flight rest.",
            "A drive for waking that occurs about 6 hours after the Window of Circadian Low.",
            "The point in the flight where the PIC must check crew alertness.",
            "A psychological habit of waking up at the same time every day."
        ],
        correct: 1
    },

    {
        question: "Which factor is most likely to increase the risk of fatigue?",
        answers: [
            "Getting adequate sleep before duty.",
            "Taking regular short breaks.",
            "Working during the body's normal sleep period.",
            "Maintaining a consistent sleep schedule."
        ],
        correct: 2
    },

    {
        question: "What is the Window of Circadian Low (WOCL)?",
        answers: [
            "The period when body temperature is at its highest.",
            "The period when the body has the greatest tendency to sleep.",
            "The period when a person normally eats breakfast.",
            "The period when physical performance is at its highest."
        ],
        correct: 1
    },

    {
        question: "Which of the following is a common symptom of fatigue?",
        answers: [
            "Improved concentration.",
            "Faster reaction time.",
            "Reduced alertness and slower reaction time.",
            "Increased ability to multitask."
        ],
        correct: 2
    },

    {
        question: "How does lack of sleep affect human performance?",
        answers: [
            "It can reduce attention, memory and decision-making ability.",
            "It always improves decision-making.",
            "It has no effect on reaction time.",
            "It only affects physical strength."
        ],
        correct: 0
    },

    {
        question: "Which activity is most appropriate for reducing fatigue during a break?",
        answers: [
            "Continuing to work without stopping.",
            "Taking a short rest in a suitable environment.",
            "Using a computer continuously.",
            "Skipping the break completely."
        ],
        correct: 1
    },

    {
        question: "What is the main purpose of fatigue risk management?",
        answers: [
            "To eliminate the need for crew rest.",
            "To identify and control fatigue-related risks.",
            "To increase the number of working hours.",
            "To replace all safety procedures."
        ],
        correct: 1
    },

    {
        question: "Which condition can make it difficult to obtain good quality sleep?",
        answers: [
            "A quiet and dark bedroom.",
            "A consistent sleep schedule.",
            "Noise, light and an unsuitable sleeping environment.",
            "Adequate rest before duty."
        ],
        correct: 2
    },

    {
        question: "Why can night duties increase fatigue?",
        answers: [
            "They always provide more sleeping time.",
            "They occur during a period when the body normally expects sleep.",
            "They automatically improve alertness.",
            "They eliminate circadian effects."
        ],
        correct: 1
    },

    {
        question: "Which is an effective personal fatigue countermeasure?",
        answers: [
            "Getting sufficient sleep.",
            "Skipping meals.",
            "Working continuously without breaks.",
            "Reducing sleep before duty."
        ],
        correct: 0
    },

    {
        question: "What should a crew member do if they recognize that fatigue may affect their performance?",
        answers: [
            "Ignore the symptoms.",
            "Continue working without informing anyone.",
            "Report the condition through the appropriate safety process.",
            "Hide the condition from the team."
        ],
        correct: 2
    },

    {
        question: "Which statement about caffeine is correct?",
        answers: [
            "Caffeine can temporarily increase alertness.",
            "Caffeine completely replaces sleep.",
            "Caffeine has no effect on alertness.",
            "Caffeine guarantees that fatigue will not occur."
        ],
        correct: 0
    },

    {
        question: "Why is a regular sleep schedule helpful?",
        answers: [
            "It supports the body's natural sleep-wake rhythm.",
            "It removes the need for sleep.",
            "It guarantees no fatigue will occur.",
            "It allows people to work indefinitely."
        ],
        correct: 0
    },

    {
        question: "Which environmental condition is generally most suitable for sleeping?",
        answers: [
            "Bright and noisy.",
            "Hot and crowded.",
            "Dark, quiet and comfortable.",
            "Continuous television and phone notifications."
        ],
        correct: 2
    },

    {
        question: "What is microsleep?",
        answers: [
            "A long period of planned sleep.",
            "A brief and involuntary episode of sleep.",
            "A type of exercise.",
            "A method of improving vision."
        ],
        correct: 1
    },

    {
        question: "Why is fatigue considered a safety risk?",
        answers: [
            "It can impair attention, judgment and reaction time.",
            "It always increases alertness.",
            "It makes communication easier.",
            "It improves situational awareness."
        ],
        correct: 0
    },

    {
        question: "Which action can help maintain alertness during a long duty period?",
        answers: [
            "Taking appropriate breaks and maintaining hydration.",
            "Avoiding all breaks.",
            "Reducing sleep before duty.",
            "Ignoring signs of tiredness."
        ],
        correct: 0
    },

    {
        question: "Which factor should be considered when assessing fatigue risk?",
        answers: [
            "Duty timing and previous sleep.",
            "Only the number of meals eaten.",
            "Only the weather outside.",
            "Only the person's age."
        ],
        correct: 0
    },

    {
        question: "What is the best way to recover from accumulated sleep loss?",
        answers: [
            "Avoiding sleep.",
            "Getting sufficient quality sleep and recovery time.",
            "Drinking more caffeine instead of sleeping.",
            "Working longer hours."
        ],
        correct: 1
    },

    {
        question: "Which statement best describes fatigue management?",
        answers: [
            "Fatigue management is only the responsibility of one person.",
            "Fatigue can be managed by recognizing risks and applying appropriate countermeasures.",
            "Fatigue cannot be influenced by sleep.",
            "Fatigue management is unnecessary when working during the day."
        ],
        correct: 1
    }

];


/* =========================================================
   VARIABLES
========================================================= */

let currentQuestion = 0;


/*
 * null = ยังไม่ได้ตอบ
 * 0-3 = index ของคำตอบที่เลือก
 */
let selectedAnswers =
    new Array(questions.length).fill(null);


/*
 * เวลา 60 นาที
 */
let timeRemaining = 60 * 60;

let timerInterval;


/*
 * ป้องกันการส่งซ้ำ
 */
let examSubmitted = false;


/* =========================================================
   DOM
========================================================= */

const examTimer =
    document.getElementById("examTimer");

const questionNumberTitle =
    document.getElementById("questionNumberTitle");

const questionText =
    document.getElementById("questionText");

const answersBox =
    document.getElementById("answersBox");

const questionGrid =
    document.getElementById("questionGrid");

const navigationCount =
    document.getElementById("navigationCount");

const previousButton =
    document.getElementById("previousButton");

const nextButton =
    document.getElementById("nextButton");

const sendButton =
    document.getElementById("sendButton");


/* =========================================================
   INITIALIZE
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        /*
         * สร้างเลขข้อ 1-20
         */
        createQuestionNavigation();


        /*
         * แสดงข้อแรก
         */
        showQuestion(0);


        /*
         * เริ่มเวลา
         */
        startTimer();


        /*
         * ซ่อน Send ตั้งแต่เริ่ม
         */
        sendButton.classList.remove("show");

    }
);


/* =========================================================
   CREATE QUESTION NUMBER NAVIGATION
========================================================= */

function createQuestionNavigation() {

    questionGrid.innerHTML = "";

    questions.forEach(
        function (question, index) {

            const button =
                document.createElement("button");

            button.type = "button";

            button.className =
                "question-number unvisited";

            button.textContent =
                index + 1;

            button.dataset.question =
                index;


            button.addEventListener(
                "click",
                function () {

                    const targetQuestion =
                        Number(
                            this.dataset.question
                        );

                    goToQuestion(targetQuestion);

                }
            );


            questionGrid.appendChild(button);

        }
    );

}


/* =========================================================
   SHOW QUESTION
========================================================= */

function showQuestion(index) {

    if (
        index < 0 ||
        index >= questions.length
    ) {
        return;
    }


    currentQuestion = index;


    const question =
        questions[index];


    /* =====================================================
       QUESTION NUMBER
    ===================================================== */

    questionNumberTitle.textContent =
        (index + 1) + ". ข้อสอบ";


    /* =====================================================
       QUESTION
    ===================================================== */

    questionText.textContent =
        question.question;


    /* =====================================================
       NAVIGATION COUNT
    ===================================================== */

    updateNavigationCount();


    /* =====================================================
       ANSWERS
    ===================================================== */

    answersBox.innerHTML = "";


    question.answers.forEach(
        function (answer, answerIndex) {

            const option =
                document.createElement("div");

            option.className =
                "answer-option";


            const radio =
                document.createElement("input");

            radio.type = "radio";

            radio.name =
                "question-" + index;

            radio.id =
                "question-" +
                index +
                "-answer-" +
                answerIndex;

            radio.value =
                answerIndex;


            /*
             * ถ้าเคยตอบไว้
             * ให้แสดงคำตอบเดิม
             */
            if (
                selectedAnswers[index] ===
                answerIndex
            ) {

                radio.checked = true;

            }


            /*
             * เมื่อเลือกคำตอบ
             */
            radio.addEventListener(
                "change",
                function () {

                    selectedAnswers[index] =
                        Number(this.value);


                    /*
                     * อัปเดตเลขข้อ
                     */
                    updateQuestionNavigation();


                    /*
                     * อัปเดตจำนวนข้อที่ตอบ
                     */
                    updateNavigationCount();


                    /*
                     * ตรวจ Send
                     */
                    updateSendButton();

                }
            );


            const label =
                document.createElement("label");

            label.htmlFor =
                radio.id;

            label.textContent =
                String.fromCharCode(
                    65 + answerIndex
                ) +
                ". " +
                answer;


            option.appendChild(radio);

            option.appendChild(label);

            answersBox.appendChild(option);

        }
    );


    /* =====================================================
       BUTTON STATE
    ===================================================== */

    previousButton.disabled =
        index === 0;


    nextButton.disabled =
        index === questions.length - 1;


    /*
     * ตรวจว่า Send ต้องแสดงหรือไม่
     */
    updateSendButton();


    /*
     * อัปเดตสีเลขข้อ
     */
    updateQuestionNavigation();

}


/* =========================================================
   UPDATE NAVIGATION COUNT
   จำนวนข้อที่ตอบแล้ว / จำนวนข้อทั้งหมด
========================================================= */

function updateNavigationCount() {

    const answeredCount =
        selectedAnswers.filter(
            function (answer) {

                return answer !== null;

            }
        ).length;


    navigationCount.textContent =
        answeredCount +
        " / " +
        questions.length;

}


/* =========================================================
   UPDATE QUESTION NAVIGATION
========================================================= */

function updateQuestionNavigation() {

    const buttons =
        document.querySelectorAll(
            ".question-number"
        );


    buttons.forEach(
        function (button, index) {

            /*
             * ล้างสถานะเดิม
             */
            button.classList.remove(
                "current",
                "unvisited",
                "answered"
            );


            /*
             * =================================================
             * 1. ข้อปัจจุบัน
             *
             * สีแดงเสมอ
             * ไม่ว่าจะตอบแล้วหรือยัง
             * =================================================
             */

            if (
                index === currentQuestion
            ) {

                button.classList.add(
                    "current"
                );

                return;

            }


            /*
             * =================================================
             * 2. ตอบแล้ว
             *
             * สีเขียว
             * =================================================
             */

            if (
                selectedAnswers[index] !== null
            ) {

                button.classList.add(
                    "answered"
                );

                return;

            }


            /*
             * =================================================
             * 3. ยังไม่ได้ตอบ
             *
             * สีขาว
             * =================================================
             */

            button.classList.add(
                "unvisited"
            );

        }
    );

}


/* =========================================================
   GO TO QUESTION
========================================================= */

function goToQuestion(index) {

    if (
        index < 0 ||
        index >= questions.length
    ) {
        return;
    }


    showQuestion(index);

}


/* =========================================================
   NEXT BUTTON
========================================================= */

nextButton.addEventListener(
    "click",
    function () {

        if (
            currentQuestion <
            questions.length - 1
        ) {

            showQuestion(
                currentQuestion + 1
            );

        }

    }
);


/* =========================================================
   PREVIOUS BUTTON
========================================================= */

previousButton.addEventListener(
    "click",
    function () {

        if (
            currentQuestion > 0
        ) {

            showQuestion(
                currentQuestion - 1
            );

        }

    }
);


/* =========================================================
   CHECK ALL ANSWERED
========================================================= */

function allQuestionsAnswered() {

    return selectedAnswers.every(
        function (answer) {

            return answer !== null;

        }
    );

}


/* =========================================================
   UPDATE SEND BUTTON
========================================================= */

function updateSendButton() {

    /*
     * ซ่อนก่อนทุกครั้ง
     *
     * ทำให้ไม่มี Send ค้าง
     * ตอนเปลี่ยนข้อ
     */
    sendButton.classList.remove("show");


    /*
     * Send จะแสดงเพียงกรณีเดียว:
     *
     * 1. อยู่ข้อ 20
     * 2. ตอบครบ 20 ข้อ
     * 3. ยังไม่ได้ส่ง
     */
    if (
        currentQuestion ===
            questions.length - 1 &&
        allQuestionsAnswered() &&
        !examSubmitted
    ) {

        sendButton.classList.add("show");

    }

}


/* =========================================================
   SEND / SUBMIT EXAM
========================================================= */

sendButton.addEventListener(
    "click",
    function () {

        /*
         * ป้องกันส่งซ้ำ
         */
        if (examSubmitted) {

            return;

        }



        /*
         * ต้องตอบครบ
         */
        if (!allQuestionsAnswered()) {

            return;

        }



        /*
         * ต้องอยู่ข้อ 20
         */
        if (
            currentQuestion !==
            questions.length - 1
        ) {

            return;

        }



        /*
         * เปลี่ยนสถานะเป็นส่งแล้ว
         */
        examSubmitted = true;



        /*
         * หยุดเวลา
         */
        clearInterval(timerInterval);



        /*
         * คำนวณคะแนน
         */
        let score = 0;



        selectedAnswers.forEach(
            function (answer, index) {

                if (
                    answer !== null &&
                    answer ===
                        questions[index].correct
                ) {

                    score++;

                }

            }
        );



        /*
         * คำนวณเปอร์เซ็นต์
         */
        const percentage =
            (score / questions.length) * 100;



        /*
         * คำนวณเวลาที่ใช้
         *
         * 60 นาที = 3600 วินาที
         */
        const totalTime = 60 * 60;

        const timeSpent =
            totalTime - timeRemaining;



        /*
         * เตรียมข้อมูลสำหรับหน้า result.php
         *
         * เปลี่ยน null เป็น -1
         * เพื่อให้ข้อที่ไม่ได้ตอบไม่ถูกนับเป็นข้อถูก
         */
        const resultData = {

            score: score,

            totalQuestions:
                questions.length,

            percentage:
                percentage,

            totalTime:
                totalTime,

            timeSpent:
                timeSpent,

            answers:
                selectedAnswers.map(
                    function (answer) {

                        return answer === null
                            ? -1
                            : answer;

                    }
                ),

            questions:
                questions

        };



        /*
         * เก็บผลสอบไว้ใน Local Storage
         */
        localStorage.setItem(
            "taxFatigueExamResult",
            JSON.stringify(resultData)
        );



        /*
         * ซ่อน Send
         */
        sendButton.classList.remove(
            "show"
        );



        /*
         * ปิดปุ่มทั้งหมด
         */
        previousButton.disabled = true;

        nextButton.disabled = true;

        sendButton.disabled = true;



        /*
         * ไปหน้า Result
         */
        window.location.href =
            "/result";

    }
);


/* =========================================================
   TIMER
========================================================= */

function startTimer() {

    updateTimerDisplay();


    timerInterval =
        setInterval(
            function () {

                timeRemaining--;


                if (
                    timeRemaining <= 0
                ) {

                    timeRemaining = 0;


                    updateTimerDisplay();


                    clearInterval(
                        timerInterval
                    );


                    timeExpired();


                    return;

                }


                updateTimerDisplay();

            },
            1000
        );

}


/* =========================================================
   TIMER DISPLAY
========================================================= */

function updateTimerDisplay() {

    const hours =
        Math.floor(
            timeRemaining / 3600
        );


    const minutes =
        Math.floor(
            (timeRemaining % 3600) / 60
        );


    const seconds =
        timeRemaining % 60;


    const formattedHours =
        String(hours).padStart(2, "0");


    const formattedMinutes =
        String(minutes).padStart(2, "0");


    const formattedSeconds =
        String(seconds).padStart(2, "0");


    examTimer.textContent =
        "Time : " +
        formattedHours +
        ":" +
        formattedMinutes +
        ":" +
        formattedSeconds;


    /*
     * ล้างสีเดิม
     */
    examTimer.classList.remove(
        "warning",
        "danger"
    );


    /*
     * เหลือ 5 นาที
     */
    if (
        timeRemaining <= 300
    ) {

        examTimer.classList.add(
            "danger"
        );

    }


    /*
     * เหลือ 10 นาที
     */
    else if (
        timeRemaining <= 600
    ) {

        examTimer.classList.add(
            "warning"
        );

    }

}


/* =========================================================
   TIME EXPIRED
========================================================= */

function timeExpired() {

    if (examSubmitted) {

        return;

    }


    /*
     * ส่งอัตโนมัติ
     */
    examSubmitted = true;


    /*
     * คำนวณคะแนน
     */
    let score = 0;


    selectedAnswers.forEach(
        function (answer, index) {

            if (
                answer !== null &&
                answer ===
                    questions[index].correct
            ) {

                score++;

            }

        }
    );


    /*
     * ซ่อน Send
     */
    sendButton.classList.remove(
        "show"
    );


    /*
     * ปิดปุ่ม
     */
    previousButton.disabled = true;

    nextButton.disabled = true;

    sendButton.disabled = true;


    /*
     * แสดงผล
     */
    alert(
        "หมดเวลาทำข้อสอบแล้ว\n\n" +
        "ระบบได้ส่งคำตอบที่มีอยู่โดยอัตโนมัติ\n\n" +
        "คะแนน: " +
        score +
        " / " +
        questions.length
    );

}