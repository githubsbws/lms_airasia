<?php

namespace App\Http\Controllers\admin;

use App\Models\AdminGroup;
use App\Models\AdminMenu;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * แสดงรายการกลุ่มผู้ใช้งาน (admin_group)
     */
    public function adminGroup()
    {
        $adminGroups = AdminGroup::where('active', 'y')->orderBy('id')->get();

        return view('admin.permission.permission-group', compact('adminGroups'));
    }

    /**
     * บันทึกกลุ่มผู้ใช้งานใหม่
     */
    public function storeAdminGroup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'group_name' => ['required', 'string', 'max:255'],
            'group_name_en' => ['required', 'string', 'max:255'],
        ]);

        AdminGroup::create([
            'group_name' => $validated['group_name'],
            'group_name_en' => $validated['group_name_en'],
            'created_by' => auth()->user()->id,
            'active' => 'y',
            'is_superuser' => false,
        ]);

        return redirect()
            ->route('admin.permission.group')
            ->with('success', __('admin/common.save'));
    }

    /**
     * แสดงหน้าแก้ไขสิทธิ์เมนูของกลุ่มผู้ใช้งาน (checkbox ต่อเมนู)
     *
     * เมนูที่ group นี้มีสิทธิ์อยู่แล้ว (permission.active = 'y') จะ checked ไว้ให้
     */
    public function editAdminGroup(AdminGroup $adminGroup)
    {
        $adminMenus = AdminMenu::where('active', 'y')->orderBy('id')->get();

        $allowedMenuIds = Permission::where('group_id', $adminGroup->id)
            ->where('active', 'y')
            ->pluck('admin_menu_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        return view('admin.permission.permission-group-edit', compact('adminGroup', 'adminMenus', 'allowedMenuIds'));
    }

    /**
     * บันทึกสิทธิ์เมนูของกลุ่มผู้ใช้งาน จาก checkbox ที่เลือก
     *
     * - เมนูที่ติ๊ก และยังไม่มี record ของ group นี้ → insert ใหม่ (active = 'y')
     * - เมนูที่ติ๊ก และมี record อยู่แล้ว → update เป็น active = 'y'
     * - เมนูที่ไม่ติ๊ก แต่มี record อยู่แล้ว (เคยให้สิทธิ์ไปก่อน) → update เป็น active = 'n'
     * - เมนูที่ไม่ติ๊ก และไม่มี record อยู่เลย → ไม่ต้องทำอะไร (ไม่ insert)
     */
    public function updateAdminGroupPermission(Request $request, AdminGroup $adminGroup): RedirectResponse
    {
        $validated = $request->validate([
            'admin_menu_ids' => ['array'],
            'admin_menu_ids.*' => ['integer', 'exists:admin_menu,id'],
        ]);

        $checkedMenuIds = array_map('intval', $validated['admin_menu_ids'] ?? []);

        $existingPermissions = Permission::where('group_id', $adminGroup->id)->get();

        foreach ($existingPermissions as $permission) {
            $isChecked = in_array((int) $permission->admin_menu_id, $checkedMenuIds, true);

            $permission->update(['active' => $isChecked ? 'y' : 'n']);
        }

        $existingMenuIds = $existingPermissions->pluck('admin_menu_id')->map(fn ($id) => (int) $id)->all();

        $newMenuIds = array_diff($checkedMenuIds, $existingMenuIds);

        foreach ($newMenuIds as $menuId) {
            Permission::create([
                'group_id' => $adminGroup->id,
                'admin_menu_id' => $menuId,
                'active' => 'y',
            ]);
        }

        return redirect()
            ->route('admin.permission.group')
            ->with('success', __('admin/common.save'));
    }

    public function updateAdminGroup(Request $request, AdminGroup $adminGroup): RedirectResponse
    {
        $validated = $request->validate([
            'group_name' => ['required', 'string', 'max:255'],
        ]);

        $adminGroup->update([
            'group_name' => $validated['group_name'],
        ]);

        return redirect()
            ->route('admin.permission.group')
            ->with('success', __('admin/common.edit').' '.__('admin/menuleft.admin_group').' '.__('admin/common.save'));
    }

    /**
     * ลบกลุ่มผู้ใช้งาน (soft delete แบบ custom — ตั้ง active = 'n' ไม่ลบจริง
     * เพื่อคงความสัมพันธ์กับ users/permission เดิมที่อาจผูกกลุ่มนี้อยู่)
     */
    public function destroyAdminGroup(AdminGroup $adminGroup): RedirectResponse
    {
        $adminGroup->update(['active' => 'n']);

        return redirect()
            ->route('admin.permission.group')
            ->with('success', __('admin/common.delete').' '.__('admin/menuleft.admin_group').' '.__('admin/common.save'));
    }
}
