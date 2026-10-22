<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Station extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'station_id';

    protected $fillable = [
        'station_title',
        'active',
    ];
}
