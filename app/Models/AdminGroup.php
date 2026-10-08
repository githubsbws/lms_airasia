<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminGroup extends Model
{
    use HasFactory;

    protected $table = 'admin_group';

    protected $fillable = [
        'group_name','group_name_en','created_by','updated_by','created_at', 'updated_at','active','is_superuser'
      ];

    /**
     * ชื่อกลุ่มตาม locale ปัจจุบัน (th → group_name, en → group_name_en)
     * fallback ไปใช้ group_name ถ้า group_name_en ว่าง (เผื่อข้อมูลเก่ายังไม่กรอก EN)
     *
     * ใช้งาน: $adminGroup->display_name
     */
    public function getDisplayNameAttribute(): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->group_name_en)) {
            return $this->group_name_en;
        }

        return $this->group_name;
    }
}
