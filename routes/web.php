<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\UserManageController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\HowtoController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HowToFrontController;
use App\Http\Controllers\FaqFrontController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
|
| Login ใช้ modal เดียวที่ header (ไม่มีหน้าแยก) — เข้าหน้า admin ได้ผ่าน
| เมนูย่อยหลัง login แล้วเท่านั้น (ดู design.md หัวข้อ 2)
|
*/
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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

Route::get('/how-to-use', [HowToFrontController::class, 'index'])->name('how-to-use');

Route::get('/faq', [FaqFrontController::class, 'index'])->name('faq');

Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');

// สลับภาษา (th/en) — เก็บค่าไว้ใน session แล้ว redirect กลับหน้าเดิม
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['th', 'en'], true)) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Admin (หลังบ้าน)
|--------------------------------------------------------------------------
|
| หมายเหตุ: ถ้าใช้ Filament v5 เป็น admin panel จริง route กลุ่มนี้จะถูก
| แทนที่ด้วย Filament ที่ mount /admin เอง (ดู design.md หัวข้อ 1)
|
*/
Route::prefix('admin')->middleware(['auth', 'ensureIsAdmin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.home');
    //permission
    Route::get('permission/group', [PermissionController::class, 'adminGroup'])->name('admin.permission.group');
    Route::post('permission/group', [PermissionController::class, 'storeAdminGroup'])->name('admin.permission.group.store');
    Route::put('permission/group/{adminGroup}', [PermissionController::class, 'updateAdminGroup'])->name('admin.permission.group.update');
    Route::delete('permission/group/{adminGroup}', [PermissionController::class, 'destroyAdminGroup'])->name('admin.permission.group.destroy');

    Route::get('permission/group/{adminGroup}/edit', [PermissionController::class, 'editAdminGroup'])->name('admin.permission.group.edit');
    Route::put('permission/group/{adminGroup}/permission', [PermissionController::class, 'updateAdminGroupPermission'])->name('admin.permission.group.permission.update');

    Route::get('permission/user', [PermissionController::class, 'adminUser'])->name('admin.permission.user');
    Route::put('permission/user/{user}/cancel', [PermissionController::class, 'cancelAdminUserPermission'])->name('admin.permission.user.cancel');

    //user manage
    Route::get('user/manage', [UserManageController::class, 'userManage'])->name('admin.user.manage');
    Route::get('user/manage/{user}/permission', [UserManageController::class, 'editPermission'])->name('admin.user.manage.permission.edit');
    Route::put('user/manage/{user}/permission', [UserManageController::class, 'updatePermission'])->name('admin.user.manage.permission.update');
    Route::get('user/manage/{user}', [UserManageController::class, 'show'])->name('admin.user.manage.show');
    Route::get('user/manage/{user}/edit', [UserManageController::class, 'edit'])->name('admin.user.manage.edit');
    Route::put('user/manage/{user}', [UserManageController::class, 'update'])->name('admin.user.manage.update');
    Route::delete('user/manage/{user}', [UserManageController::class, 'destroy'])->name('admin.user.manage.destroy');

    //howto
    Route::get('howto/create', [HowtoController::class, 'howtoCreate'])->name('admin.howto.create');
    Route::post('howto/create', [HowtoController::class, 'store'])->name('admin.howto.store');
    Route::get('howto/list', [HowtoController::class, 'howtoList'])->name('admin.howto.list');
    Route::get('howto/{howTo}/edit', [HowtoController::class, 'edit'])->name('admin.howto.edit');
    Route::put('howto/{howTo}', [HowtoController::class, 'update'])->name('admin.howto.update');
    Route::delete('howto/{howTo}', [HowtoController::class, 'destroy'])->name('admin.howto.destroy');

    //faq
    Route::get('faq/create', [FaqController::class, 'faqCreate'])->name('admin.faq.create');
    Route::post('faq/create', [FaqController::class, 'store'])->name('admin.faq.store');
    Route::get('faq/list', [FaqController::class, 'faqList'])->name('admin.faq.list');
    Route::get('faq/{faq}/edit', [FaqController::class, 'edit'])->name('admin.faq.edit');
    Route::put('faq/{faq}', [FaqController::class, 'update'])->name('admin.faq.update');
    Route::delete('faq/{faq}', [FaqController::class, 'destroy'])->name('admin.faq.destroy');

});
