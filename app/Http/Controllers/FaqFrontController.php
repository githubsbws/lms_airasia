<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\View\View;

class FaqFrontController extends Controller
{
    /**
     * แสดงหน้า FAQ ฝั่ง user — ดึงคำถามที่พบบ่อยทั้งหมดตามภาษาที่ user
     * กำลังใช้อยู่ (set โดย SetLocale middleware) เรียงตาม id ล่าสุดก่อน
     */
    public function index(): View
    {
        $faqs = Faq::where('lang', app()->getLocale())
            ->where('active', 'y')
            ->orderBy('id')
            ->get();

        return view('frontend.faq', compact('faqs'));
    }
}
