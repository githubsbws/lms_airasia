<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function faqCreate(): View
    {
        return view('admin.faq.faq-create');
    }

    /**
     * บันทึกคำถามที่พบบ่อยใหม่ — สร้าง 2 แถวเสมอ (th + en)
     * แถว th คือ record ต้นฉบับ (parent_id = null)
     * แถว en เป็นคำแปล ผูกกับ th ผ่าน parent_id = id ของแถว th
     *
     * หน้า create รับแค่คำถาม ยังไม่มีคำตอบ — คำตอบไปกรอกทีหลังผ่าน
     * หน้าแก้ไข (แก้ไข(TH)/แก้ไข(EN)) เพื่อไม่ให้ฟอร์มสร้างรก
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'faq_name_th' => ['required', 'string', 'max:255'],
            'faq_name_en' => ['required', 'string', 'max:255'],
        ]);

        $th = Faq::create([
            'faq_name' => $validated['faq_name_th'],
            'lang' => 'th',
            'parent_id' => null,
            'active' => 'y',
        ]);

        Faq::create([
            'faq_name' => $validated['faq_name_en'],
            'lang' => 'en',
            'parent_id' => $th->id,
            'active' => 'y',
        ]);

        return redirect()
            ->route('admin.faq.list')
            ->with('success', __('admin/faq.created'));
    }

    /**
     * แสดงรายการคำถามที่พบบ่อย — ดึงเฉพาะแถวต้นฉบับ (lang = th, parent_id = null)
     * แล้ว eager-load แถว en คู่กันผ่าน relation translation()
     * เงื่อนไข active = 'y' เท่านั้น (ถูก soft-delete ไปแล้วจะไม่แสดง)
     */
    public function faqList(): View
    {
        $faqs = Faq::with('translation')
            ->whereNull('parent_id')
            ->where('active', 'y')
            ->orderByDesc('id')
            ->get();

        return view('admin.faq.faq-list', compact('faqs'));
    }

    /**
     * แก้ไขคำถามที่พบบ่อยของภาษาเดียว (แก้ไขทีละแถว ไม่กระทบคู่แปล)
     * $faq คือแถว th หรือ en ก็ได้ ขึ้นอยู่กับปุ่มที่ user กด (แก้ไข(TH)/แก้ไข(EN))
     */
    public function edit(Faq $faq): View
    {
        return view('admin.faq.faq-edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'faq_name' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        $faq->update([
            'faq_name' => $validated['faq_name'],
            'answer' => $validated['answer'],
        ]);

        return redirect()
            ->route('admin.faq.list')
            ->with('success', __('admin/faq.updated'));
    }

    /**
     * ลบคำถามที่พบบ่อย — soft delete ด้วย active = 'n'
     * ลบทั้งคู่ (th + en) พร้อมกันเสมอ ไม่ว่าจะกดลบจากแถวไหน เพื่อไม่ให้
     * เหลือคำแปลลอยไม่มีต้นฉบับคู่กัน
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        $parentId = $faq->parent_id ?? $faq->id;

        Faq::where('id', $parentId)
            ->orWhere('parent_id', $parentId)
            ->update(['active' => 'n']);

        return redirect()
            ->route('admin.faq.list')
            ->with('success', __('admin/faq.deleted'));
    }
}
