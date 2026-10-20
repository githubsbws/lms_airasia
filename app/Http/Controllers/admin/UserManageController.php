<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Users;
use App\Models\Profiles;
use App\Models\AdminGroup;
use App\Helpers\DateHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManageController extends Controller
{
    public function userManage()
    {
        $userMembers = Users::with('profile')
            ->where('del_status', '0')
            ->orderBy('id')
            ->get()
            ->map(fn (Users $user) => [
                'id' => $user->id,
                'fullname' => trim(($user->profile->firstname ?? '').' '.($user->profile->lastname ?? '')) ?: null,
                'email' => $user->email,
                'register_date' => DateHelper::formatThaiDate($user->created_at),
                'lastvisit_at' => DateHelper::formatThaiDate($user->lastvisit_at),
                'privilage' => empty($user->group) ? 'ผู้ใช้งาน' : 'ผู้ดูแลระบบ',
                // 'status' => $user->del_status == 1 ? 'ปิดการใช้งาน' : 'เปิดการใช้งาน',
            ]);
        return view('admin.usermange.user-manage',compact('userMembers'));
    }

    /**
     * หน้าแก้ไขสิทธิ์ของ user คนเดียว — เลือกกลุ่มสิทธิ์ (admin_group) ผ่าน
     * dropdown ธรรมดา ไม่ใช้ modal (ตามที่ตกลง เอาแบบง่ายที่สุด)
     *
     * ถ้า $user->group เป็น null (ยังไม่มีสิทธิ์แอดมิน) dropdown จะไม่มี
     * ค่า selected ไว้ล่วงหน้า ให้ user เลือกเองจากเปล่า
     */
    public function editPermission(Users $user): View
    {
        $adminGroups = AdminGroup::where('active', 'y')->orderBy('id')->get();

        $fullname = trim(($user->profile->firstname ?? '').' '.($user->profile->lastname ?? '')) ?: $user->email;

        return view('admin.usermange.user-permission-edit', [
            'user' => $user,
            'adminGroups' => $adminGroups,
            'fullname' => $fullname,
            // ใช้ accessor group_id (ใน Users model) แทนการ cast $user->group
            // ตรงๆ เพราะข้อมูลเก่าบางส่วนเก็บ group เป็น JSON string
            // เช่น '["7"]' ซึ่ง (int) cast ตรงๆจะได้ 0 ผิด — group_id
            // parse ให้ปลอดภัยทั้งข้อมูลเก่า (คืน null ถ้า parse ไม่ได้)
            // และข้อมูลใหม่ (เลขเดี่ยวตรงๆ) ไว้แล้ว
            'currentGroupId' => $user->group_id,
        ]);
    }

    /**
     * บันทึกสิทธิ์ที่เลือกจาก dropdown ให้ user คนนี้
     *
     * เลือก "ไม่มีสิทธิ์ (ผู้ใช้งานทั่วไป)" → เซ็ต group เป็น null, superuser เป็น 0
     * เลือกกลุ่มใดกลุ่มหนึ่ง → เซ็ต group เป็น id ของกลุ่มนั้น
     *   - ถ้า group ที่เลือกคือ id 1 → เซ็ต superuser เป็น 1 ด้วย
     *   - ถ้าไม่ใช่ id 1 → เซ็ต superuser เป็น 0
     *
     * TODO (ตัดสินใจทีหลัง — ดู .kiro/specs/ets-lms/design.md หัวข้อ "Known
     * Issues / ค้างตัดสินใจ"): ตอนนี้ method นี้ไม่เช็คว่าผู้ที่เรียกมีสิทธิ์
     * แก้ไข $user คนนี้จริงหรือไม่ (เช็คแค่ auth + ensureIsAdmin ว่าเข้าโซน
     * /admin ได้ ไม่ได้เช็คว่าแก้ "คนนี้" ได้) เสี่ยง privilege escalation —
     * admin ธรรมดาที่เข้า /admin ได้ สามารถแก้ URL เป็น id ของใครก็ได้ รวมถึง
     * ยกตัวเองเป็น group 1 (superuser) ได้ทันที ต้องเพิ่มเช็คสิทธิ์เฉพาะ
     * (เช่น เฉพาะ superuser เท่านั้นที่เรียก method นี้ได้) ก่อนขึ้น production
     */
    public function updatePermission(Request $request, Users $user): RedirectResponse
    {
        $validated = $request->validate([
            'group' => ['nullable', 'integer', 'exists:admin_group,id'],
        ]);

        $groupId = $validated['group'] ?? null;

        $user->update([
            'group' => $groupId,
            'superuser' => $groupId == 1 ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.user.manage')
            ->with('success', __('admin/common.save'));
    }

    /**
     * หน้าดูข้อมูล user คนเดียวแบบ read-only (ปุ่ม view ในตาราง)
     */
    public function show(Users $user): View
    {
        $user->load('profile');

        return view('admin.usermange.user-show', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    /**
     * หน้าแก้ไขข้อมูลโปรไฟล์ของ user คนเดียว (ปุ่ม edit ในตาราง)
     *
     * คนละเรื่องกับ editPermission() ด้านบน — อันนี้แก้ข้อมูลส่วนตัว
     * (ชื่อ-สกุล, เลขบัตร, เบอร์โทร ฯลฯ) ไม่ใช่สิทธิ์การใช้งาน
     */
    public function edit(Users $user): View
    {
        $user->load('profile');

        return view('admin.usermange.user-edit', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    /**
     * บันทึกข้อมูลโปรไฟล์ที่แก้ไข
     *
     * รหัสผ่าน: กรอกเฉพาะตอนต้องการเปลี่ยน (ถ้าเว้นว่างไว้ จะไม่แก้รหัสผ่านเดิม)
     * title_id / org_id / department_id / station_id: ยังไม่มี field ให้เลือกจริง
     * (ตามที่ตกลงไว้ ทำช่องเปล่าไว้ก่อน) จึงยังไม่ validate/บันทึกค่าพวกนี้
     */
    public function update(Request $request, Users $user): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'identification' => ['nullable', 'string', 'max:50'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'tel' => ['nullable', 'string', 'max:20'],
        ]);

        $userData = [
            'username' => $validated['username'],
        ];

        if (! empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        Profiles::updateOrCreate(
            ['user_id' => $user->id],
            [
                'identification' => $validated['identification'] ?? null,
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'tel' => $validated['tel'] ?? null,
            ]
        );

        return redirect()
            ->route('admin.user.manage')
            ->with('success', __('admin/common.save'));
    }

    /**
     * ลบ user (soft delete — ตั้ง del_status = 1 ไม่ลบข้อมูลจริง)
     */
    public function destroy(Users $user): RedirectResponse
    {
        $user->update(['del_status' => 1]);

        return redirect()
            ->route('admin.user.manage')
            ->with('success', __('admin/common.delete').__('admin/common.save'));
    }
}
