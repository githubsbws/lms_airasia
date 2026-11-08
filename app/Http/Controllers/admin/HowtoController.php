<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\HowTo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HowtoController extends Controller
{
    /**
     * โฟลเดอร์เก็บไฟล์ PDF ของ how-to บน disk "public"
     * (storage/app/public/howto -> เข้าถึงผ่าน URL /storage/howto/...)
     */
    private const UPLOAD_PATH = 'howto';

    public function howtoCreate(): View
    {
        return view('admin.howto.how-to-create');
    }

    /**
     * บันทึกหัวข้อ how-to ใหม่ — สร้าง 2 แถวเสมอ (th + en)
     * แถว th คือ record ต้นฉบับ (parent_id = null)
     * แถว en เป็นคำแปล ผูกกับ th ผ่าน parent_id = id ของแถว th
     *
     * หน้า create รับแค่ชื่อหัวข้อ ยังไม่มีไฟล์ PDF — ไฟล์แนบไปอัปโหลด
     * ทีหลังผ่านหน้าแก้ไข (แก้ไข(TH)/แก้ไข(EN)) เพื่อไม่ให้ฟอร์มสร้างรก
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'how_to_name_th' => ['required', 'string', 'max:255'],
            'how_to_name_en' => ['required', 'string', 'max:255'],
        ]);

        $th = HowTo::create([
            'how_to_name' => $validated['how_to_name_th'],
            'lang' => 'th',
            'parent_id' => null,
            'active' => 'y',
        ]);

        HowTo::create([
            'how_to_name' => $validated['how_to_name_en'],
            'lang' => 'en',
            'parent_id' => $th->id,
            'active' => 'y',
        ]);

        return redirect()
            ->route('admin.howto.list')
            ->with('success', __('admin/howto.created'));
    }

    /**
     * แสดงรายการหัวข้อ how-to — ดึงเฉพาะแถวต้นฉบับ (lang = th, parent_id = null)
     * แล้ว eager-load แถว en คู่กันผ่าน relation translation()
     * เงื่อนไข active = 'y' เท่านั้น (ถูก soft-delete ไปแล้วจะไม่แสดง)
     */
    public function howtoList(): View
    {
        $howTos = HowTo::with('translation')
            ->whereNull('parent_id')
            ->where('active', 'y')
            ->orderByDesc('id')
            ->get();

        return view('admin.howto.how-to-list', compact('howTos'));
    }

    /**
     * แก้ไขหัวข้อ how-to ของภาษาเดียว (แก้ไขทีละแถว ไม่กระทบคู่แปล)
     * $howTo คือแถว th หรือ en ก็ได้ ขึ้นอยู่กับปุ่มที่ user กด (แก้ไข(TH)/แก้ไข(EN))
     */
    public function edit(HowTo $howTo): View
    {
        return view('admin.howto.how-to-edit', compact('howTo'));
    }

    /**
     * อัปเดตหัวข้อ how-to ของภาษาเดียว — ถ้ามีไฟล์ใหม่แนบมาจะลบไฟล์เดิม
     * (ถ้ามี) ออกจาก storage ก่อน แล้วค่อยเก็บไฟล์ใหม่ทับ
     */
    public function update(Request $request, HowTo $howTo): RedirectResponse
    {
        $validated = $request->validate([
            'how_to_name' => ['required', 'string', 'max:255'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $data = [
            'how_to_name' => $validated['how_to_name'],
        ];

        if ($request->hasFile('file')) {
            if ($howTo->filename) {
                Storage::disk('public')->delete(self::UPLOAD_PATH.'/'.$howTo->filename);
            }

            $data['filename'] = $this->storePdf($request, 'file');
        }

        $howTo->update($data);

        return redirect()
            ->route('admin.howto.list')
            ->with('success', __('admin/howto.updated'));
    }

    /**
     * ลบหัวข้อ how-to — soft delete ด้วย active = 'n'
     * ลบทั้งคู่ (th + en) พร้อมกันเสมอ ไม่ว่าจะกดลบจากแถวไหน เพื่อไม่ให้
     * เหลือคำแปลลอยไม่มีต้นฉบับคู่กัน พร้อมลบไฟล์ PDF ของทั้งคู่จาก storage
     */
    public function destroy(HowTo $howTo): RedirectResponse
    {
        $parentId = $howTo->parent_id ?? $howTo->id;

        $pair = HowTo::where('id', $parentId)
            ->orWhere('parent_id', $parentId)
            ->get();

        foreach ($pair as $row) {
            if ($row->filename) {
                Storage::disk('public')->delete(self::UPLOAD_PATH.'/'.$row->filename);
            }
        }

        HowTo::where('id', $parentId)
            ->orWhere('parent_id', $parentId)
            ->update(['active' => 'n']);

        return redirect()
            ->route('admin.howto.list')
            ->with('success', __('admin/howto.deleted'));
    }

    /**
     * เก็บไฟล์ PDF ลง disk "public" โฟลเดอร์ howto/ ถ้ามีไฟล์แนบมาจริง
     * คืนค่าเป็นชื่อไฟล์ (เก็บลง column filename) หรือ null ถ้าไม่มีไฟล์
     */
    private function storePdf(Request $request, string $field): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $path = $request->file($field)->store(self::UPLOAD_PATH, 'public');

        return basename($path);
    }
}
