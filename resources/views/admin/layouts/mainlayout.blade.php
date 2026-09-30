{{--
    Layout ฝั่ง Admin (หลังบ้าน) — AdminLTE v4 + Bootstrap 5
    โครง app-wrapper/app-header/app-sidebar/app-main/app-footer ตาม
    AdminLTE v4 blueprint (ดู design.md หัวข้อ 1: เปลี่ยนจาก Filament → AdminLTE)
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'ETS') }} Admin</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])

    @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        @include('admin.partials.header')

        @include('admin.partials.menu-left')

        <main class="app-main">

            @if (session('idle_timeout_message'))
                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('idle_timeout_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">@yield('title', 'Dashboard')</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

        </main>

        @include('admin.partials.footer')

    </div>

    @stack('scripts')

</body>
</html>
