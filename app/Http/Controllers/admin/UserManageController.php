<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;

class UserManageController extends Controller
{
    public function userManage()
    {
        $userMembers = Users::with('profile')
            ->where('del_status', '0')
            ->orderBy('id')
            ->get()
            ->map(fn (Users $user) => [
                'id' => $user->id,
                'fullname' => trim(($user->profile->firstname ?? '').' '.($user->profile->lastname ?? '')) ?: null,
                'email' => $user->email,
            ]);
        return view('admin.usermange.user-manage',compact('userMembers'));
    }
}
