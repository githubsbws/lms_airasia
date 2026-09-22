{{--
    Layout ฝั่ง Admin (หลังบ้าน)
    หมายเหตุ: ถ้า admin panel หลักใช้ Filament PHP v5 (mount ที่ /admin ตาม design.md)
    layout นี้จะใช้เฉพาะกรณีมีหน้า admin แบบ Blade เองเพิ่มเติมที่ไม่ได้อยู่ใน Filament
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'ETS') }} Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column">

    @include('admin.partials.header')

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('admin.partials.footer')

</body>
</html>
