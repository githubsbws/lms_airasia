<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name', 'ETS')) | {{ config('app.name', 'ETS') }}</title>

    {{-- Bootstrap Icons + Font Awesome (icon glyphs เท่านั้น ยังคงโหลดผ่าน CDN เหมือนต้นแบบ UI เดิม) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">

    {{-- Bootstrap 5 (bundle เข้ากับ app.css/app.js ผ่าน Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Stylesheet ของหน้าบ้านที่แปลงมาจาก lms-airasia-html (รวมทุกหน้าไว้ไฟล์เดียว) --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    @stack('styles')
</head>
<body class="d-flex flex-column">

    @include('partials.header')

    <main class="flex-grow-1 d-flex flex-column">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')

</body>
</html>
