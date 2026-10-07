<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\CheckIdleTimeout::class,
        ]);

        $middleware->alias([
            'checkIdleTimeout' => \App\Http\Middleware\CheckIdleTimeout::class,
            'ensureIsAdmin' => \App\Http\Middleware\EnsureIsAdmin::class,
        ]);

        // ยังไม่มีหน้า login แยก (ใช้ modal ที่ header) — ถ้า guest เข้าหน้าที่ต้อง login
        // (เช่น /admin/*) ให้เด้งไปหน้าแรกแทนปลายทาง default ('login' route ที่ไม่มีจริง)
        $middleware->redirectGuestsTo(fn () => route('home'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
