<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faq';

    protected $fillable = [
        'faq_name','lang','parent_id','answer','created_at', 'updated_at','active'
      ];

    /**
     * แถวต้นฉบับ (lang = th) มี parent_id = null
     * แถวคำแปล (lang = en) ผูกกับต้นฉบับผ่าน parent_id = id ของแถว th
     * relation นี้ใช้จากฝั่งแถว th เพื่อหาแถว en คู่กัน
     */
    public function translation(): HasOne
    {
        return $this->hasOne(Faq::class, 'parent_id', 'id');
    }
}
