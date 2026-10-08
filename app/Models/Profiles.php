<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $table = 'profiles'; // ตาม prefix connection
    protected $primaryKey = 'user_id';
    public $incrementing = false; // สำคัญมาก! บอก Eloquent ว่า PK นี้ไม่ auto-increment

    protected $fillable = [
        'user_id',
        'title_id',
        'firstname',
        'lastname', 'firstname_en', 'lastname_en', 'identification','tel', 'type_iden',
    ];

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }
}
