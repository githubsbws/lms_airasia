<?php

namespace App\Http\Controllers;

use App\Models\HowTo;
use Illuminate\View\View;

class HowToFrontController extends Controller
{
    /**
     * แสดงหน้า "วิธีการใช้งาน" ฝั่ง user — ดึงหัวข้อ how-to ทั้งหมดตาม
     * ภาษาที่ user กำลังใช้อยู่ (set โดย SetLocale middleware)
     *
     * แสดงทุกหัวข้อที่ active = 'y' แม้ยังไม่มีไฟล์ PDF แนบก็ตาม
     * (การ์ดที่ไม่มีไฟล์จะแสดงผลแบบกดไม่ได้ ดูที่ view how-to-use.blade.php)
     */
    public function index(): View
    {
        $howTos = HowTo::where('lang', app()->getLocale())
            ->where('active', 'y')
            ->orderBy('how_to_name')
            ->get();

        return view('frontend.how-to-use', compact('howTos'));
    }
}
