<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * สลับภาษาของทั้งระบบ (th/en) ตามลำดับความสำคัญ:
 * 1. ผู้ใช้ login แล้ว และมี language_pref เก็บไว้ที่ user (ยังไม่ implement เพราะ auth ยังไม่เสร็จ)
 * 2. เคยเลือกภาษาไว้ใน session (จากปุ่มสลับภาษา)
 * 3. ค่า default จาก config('app.locale') / .env APP_LOCALE
 */
class SetLocale
{
    /**
     * ภาษาที่ระบบรองรับ ป้องกันการยิง locale แปลกๆเข้ามาทาง route
     *
     * @var array<int, string>
     */
    protected array $supportedLocales = ['th', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale'));

        if (! in_array($locale, $this->supportedLocales, true)) {
            $locale = config('app.locale');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
