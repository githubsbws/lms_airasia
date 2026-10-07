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

        if (! $user || ! $this->checkPassword($user, $credentials['password'])) {
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

    /**
     * ตรวจสอบรหัสผ่าน รองรับข้อมูลเก่าที่เก็บเป็น MD5 (migrate มาจากระบบเดิม)
     *
     * ถ้ารหัสผ่านที่เก็บไว้เป็นรูปแบบ MD5 (hex 32 ตัวอักษร) และตรงกับที่ผู้ใช้กรอก
     * จะอัปเกรดเป็น Laravel hash (bcrypt) ทันทีแล้วบันทึกทับของเดิม
     * ถ้าไม่ใช่ MD5 ก็ตรวจสอบด้วย Hash::check ตามปกติ
     */
    private function checkPassword(Users $user, string $plainPassword): bool
    {
        $storedPassword = $user->password;

        if ($this->isMd5Hash($storedPassword)) {
            if (! hash_equals($storedPassword, md5($plainPassword))) {
                return false;
            }

            // รหัสผ่านถูกต้อง (ตรวจผ่าน MD5) — อัปเกรดเป็น Laravel hash แล้วบันทึกทับ
            $user->forceFill(['password' => $plainPassword])->save();

            return true;
        }

        return Hash::check($plainPassword, $storedPassword);
    }

    /**
     * ตรวจว่า string เป็นรูปแบบ MD5 hash หรือไม่ (hex 32 ตัวอักษรล้วน)
     */
    private function isMd5Hash(string $value): bool
    {
        return (bool) preg_match('/^[a-f0-9]{32}$/i', $value);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
