<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    use HasFactory;

    protected $table = 'admin_menu';

    protected $fillable = [
        'name','url', 'parent_id', 'created_at', 'updated_at','active'
      ];
}
