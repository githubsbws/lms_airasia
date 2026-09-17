{{-- =========================================================
| Header: ฝั่ง Admin (หลังบ้าน)
| แยกไว้ในโฟลเดอร์ admin โดยเฉพาะ ไม่ปนกับหน้าบ้าน
| หมายเหตุ: ถ้าใช้ Filament PHP v5 เป็น admin panel จริง
| ไฟล์นี้จะใช้เฉพาะกรณีทำหน้า admin แบบ Blade เองเพิ่มเติม
| ใช้ร่วมกับ resources/views/admin/layouts/mainlayout.blade.php
========================================================== --}}
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ url('/admin') }}">
                {{ config('app.name', 'ETS') }} <span class="badge bg-secondary ms-1">Admin</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#adminNavbar" aria-controls="adminNavbar"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">สมาชิก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">หลักสูตร</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">รายงาน</a>
                    </li>

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">ตั้งค่าบัญชี</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">ออกจากระบบ</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#">เข้าสู่ระบบ</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
