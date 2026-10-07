<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function adminGroup()
    {
        return view('admin.permission.permission-group');
    }
}
