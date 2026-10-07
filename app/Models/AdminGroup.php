<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminGroup extends Model
{
    use HasFactory;

    protected $table = 'admin_group';

    protected $fillable = [
        'group_name','created_at', 'updated_at','active','is_supersuer'
      ];
}
