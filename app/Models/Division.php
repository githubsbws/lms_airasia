<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Division extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'division_id',
        'dep_title',
        'active',
    ];
}
