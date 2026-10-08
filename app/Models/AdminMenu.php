<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    use HasFactory;

    protected $table = 'admin_menu';

    protected $fillable = [
        'name','url','created_at', 'updated_at','active'
      ];

    /**
     * ชื่อเมนูตาม locale ปัจจุบัน — แมปจาก config/admin_menu.php (id → key)
     * แล้วแปลผ่าน lang/{locale}/admin/menuleft.php
     *
     * fallback ไปใช้ column `name` จาก DB ตรงๆ ถ้าเมนูนี้ไม่ได้ผูกไว้ใน config
     * (เช่น เมนูที่ยังไม่ได้เพิ่มเข้า sidebar)
     *
     * ใช้งาน: $adminMenu->display_name
     */
    public function getDisplayNameAttribute(): string
    {
        $key = $this->findMenuKey();

        if ($key === null) {
            return $this->name;
        }

        return __('admin/menuleft.'.$key);
    }

    /**
     * ไล่หา key ของเมนูนี้ใน config/admin_menu.php (รวมเมนูลูกใน children ด้วย)
     * โดยเทียบจาก id ที่ตรงกับ admin_menu.id ของ record นี้
     */
    protected function findMenuKey(): ?string
    {
        foreach (config('admin_menu', []) as $item) {

            if (($item['id'] ?? null) === $this->id) {
                return $item['key'];
            }
        }

        return null;
    }
}
