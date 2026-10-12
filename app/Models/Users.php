<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'org_id', 'pic_user', 'department_id', 'activkey','lastvisit_at', 'superuser', 'status', 'online_status', 'online_user',
        'group', 'del_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Profile ของ user คนนี้ (ความสัมพันธ์ 1:1 — profiles.user_id เป็นทั้ง PK และ FK)
     */
    public function profile()
    {
        return $this->hasOne(Profiles::class, 'user_id', 'id');
    }

    /**
     * ความสัมพันธ์ไปยัง AdminGroup ผ่าน column `group` ตรงๆ
     *
     * ⚠️ ใช้ไม่ได้กับ user เก่าที่ column `group` ยังเป็น JSON array string
     * (เช่น '["7"]") เพราะ relation เทียบ `group = admin_group.id` ตรงๆ
     * จะหา record ไม่เจอ (ได้ null) ไม่ error แต่ก็ไม่ได้ค่าเช่นกัน
     *
     * สำหรับดึงชื่อกลุ่มที่ปลอดภัยกับข้อมูลทั้งเก่าและใหม่ ให้ใช้
     * accessor `$user->group_name` แทน (parse ค่าแบบปลอดภัยไว้ให้แล้ว)
     */
    public function groupName()
    {
        return $this->belongsTo(AdminGroup::class, 'group', 'id');
    }

    /**
     * group_id เดี่ยวที่ user นี้สังกัด (รูปแบบใหม่ — ค่าตรงๆ ไม่ใช่ JSON array)
     *
     * หมายเหตุ: ข้อมูลเก่าบางส่วนจากระบบเดิมยังเก็บ column `group` เป็น
     * JSON array string (เช่น ["7"]) ค้างไว้โดยตั้งใจไม่ migrate — เคสนั้น
     * ให้ถือว่า "parse ไม่ได้ตามรูปแบบใหม่" แล้วคืน null ไปก่อน (ไม่ error)
     */
    public function getGroupIdAttribute(): ?int
    {
        if (is_null($this->attributes['group'] ?? null) || $this->attributes['group'] === '') {
            return null;
        }

        $raw = $this->attributes['group'];

        // รูปแบบใหม่: ตัวเลขเดี่ยวตรงๆ (string หรือ int ก็ได้)
        if (is_numeric($raw)) {
            return (int) $raw;
        }

        // ข้อมูลเก่า: JSON array string เช่น ["7"] — ไม่รองรับ ให้ null ไปก่อน
        return null;
    }

    /**
     * ชื่อกลุ่มสิทธิ์ตาม locale ปัจจุบัน (ผ่าน AdminGroup::display_name
     * เพื่อให้สลับ th/en ได้ตามภาษาที่ใช้งานอยู่) ตาม group_id ของ user นี้
     * คืน null ถ้าไม่มี group หรือหา group ไม่เจอ (เช่น ข้อมูลเก่าที่ยัง
     * เป็น JSON array ค้างอยู่ หรือ group ถูกลบไปแล้ว)
     */
    public function getGroupNameAttribute(): ?string
    {
        $groupId = $this->group_id;

        if (is_null($groupId)) {
            return null;
        }

        return AdminGroup::find($groupId)?->display_name;
    }

}
