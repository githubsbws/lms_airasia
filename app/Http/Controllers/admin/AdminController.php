<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    /**
     * หน้า Dashboard หลักของ Admin Panel (route: admin.home)
     */
    public function index(): View
    {
        return view('admin.home');
    }
}
