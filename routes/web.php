<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend (ฝั่ง User)
|--------------------------------------------------------------------------
|
| แปลงมาจาก lms-airasia-html/*.php (UI ที่ทีม Frontend ทำไว้)
| ตอนนี้เป็น static view ก่อน (ยังไม่ผูก database/model จริง)
|
*/

Route::get('/', function () {
    return view('frontend.index');
})->name('home');

Route::get('/course', function () {
    return view('frontend.course');
})->name('course.index');

Route::get('/course/detail', function () {
    return view('frontend.course-detail');
})->name('course.detail');

Route::get('/course/exam', function () {
    return view('frontend.course-exam');
})->name('course.exam');

Route::get('/final-exam', function () {
    return view('frontend.final-exam');
})->name('exam.final');

Route::get('/exam', function () {
    return view('frontend.exam');
})->name('exam.test');

Route::get('/result', function () {
    return view('frontend.result');
})->name('exam.result');

Route::get('/document', function () {
    return view('frontend.document');
})->name('document.index');

Route::get('/how-to-use', function () {
    return view('frontend.how-to-use');
})->name('how-to-use');

Route::get('/faq', function () {
    return view('frontend.faq');
})->name('faq');

Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');

/*
|--------------------------------------------------------------------------
| Admin (หลังบ้าน)
|--------------------------------------------------------------------------
|
| หมายเหตุ: ถ้าใช้ Filament v5 เป็น admin panel จริง route กลุ่มนี้จะถูก
| แทนที่ด้วย Filament ที่ mount /admin เอง (ดู design.md หัวข้อ 1)
|
*/
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.home');
    })->name('admin.home');
});
