<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * บล็อกการเข้าหน้า admin สำหรับ user ที่ไม่มีสิทธิ์
 *
 * เงื่อนไข: ถ้า group_id เป็น null และ superuser เป็น 0 (ไม่ใช่ superuser)
 * ถือว่าไม่มีสิทธิ์เข้า /admin/* ให้เด้งไปหน้าแรกทันที
 *
 * ต้องใช้คู่กับ 'auth' middleware เสมอ (รันหลัง auth เพื่อให้มั่นใจว่า
 * มี user login อยู่แล้วก่อนเช็ค group_id/superuser)
 */
class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->group_id === null && (int) $user->superuser === 0) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
