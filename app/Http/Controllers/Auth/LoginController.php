<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * เข้าสู่ระบบด้วย username + password (แสดงผลผ่าน modal ที่ header)
     *
     * เช็ค del_status ก่อนทุกครั้ง — ถ้าเป็น 1 (ถูกลบ/ปิดใช้งาน) ห้าม login
     * แม้ username/password จะถูกต้องก็ตาม
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = Users::where('username', $credentials['username'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'username' => __('auth.failed'),
            ]);
        }

        if ((int) $user->del_status === 1) {
            throw ValidationException::withMessages([
                'username' => __('auth.deleted'),
            ]);
        }

        if ((int) $user->status !== 1) {
            throw ValidationException::withMessages([
                'username' => __('auth.inactive'),
            ]);
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        $user->forceFill(['lastvisit_at' => now()])->save();

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
