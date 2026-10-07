{{-- =========================================================
| Sidebar เมนูซ้าย: ฝั่ง Admin (AdminLTE v4)
| อ่านโครงเมนูจาก config/admin_menu.php และคำแปลจาก
| lang/{locale}/admin/menuleft.php ผ่าน admin/menuleft.{key}
|
| หมายเหตุ: ยังไม่กรองตาม permission จริง (tbl_admin_group/tbl_permission)
| ตอนนี้ superuser หรือไม่ก็เห็นเมนูเหมือนกันหมดไปก่อน — จะผูก
| Gate::define('menu', ...) + @canmenu() ทีหลังตาม design.md หัวข้อ 2
========================================================== --}}
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <div class="sidebar-brand">
        <a href="{{ route('admin.home') }}" class="brand-link">
            <img
                src="{{ asset('frontend/images/logo.png') }}"
                alt="{{ config('app.name', 'ETS') }}"
                class="brand-image opacity-75 shadow"
                style="max-height: 33px;">
            <span class="brand-text fw-light">{{ config('app.name', 'ETS') }} Admin</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                @foreach (config('admin_menu', []) as $item)

                    @continue(! empty($item['id']) && ! \App\Helpers\PermissionHelper::canMenu($item['id']))

                    @php
                        $hasChildren = ! empty($item['children']);
                        $label = __('admin/menuleft.'.$item['key']);
                        $isActive = ! empty($item['route']) && request()->routeIs($item['route']);

                        // เมนูมี children: ถือว่า "active/เปิดไว้" ถ้า route ปัจจุบันตรงกับ
                        // child ตัวไหนตัวหนึ่ง — ใช้ class menu-open ของ AdminLTE เพื่อให้
                        // sub-menu แสดงอยู่ (ไม่ซ่อน) และ parent link ไฮไลต์ตามไปด้วย
                        $hasActiveChild = $hasChildren && collect($item['children'])
                            ->contains(fn ($child) => ! empty($child['route']) && request()->routeIs($child['route']));

                        $href = ! empty($item['route']) ? route($item['route']) : '#';
                    @endphp

                    <li class="nav-item {{ $hasActiveChild ? 'menu-open' : '' }}">

                        <a href="{{ $href }}" class="nav-link {{ $isActive ? 'active' : '' }}">
                            <i class="nav-icon {{ $item['icon'] ?? 'bi-dot' }}"></i>
                            <p>
                                <span class="menu-label-text">
                                    @if (! empty($item['badge']))
                                        <span class="menu-step-badge">{{ $item['badge'] }}</span>
                                    @endif
                                    {{ $label }}
                                </span>
                                @if ($hasChildren)
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                @endif
                            </p>
                        </a>

                        @if ($hasChildren)
                            <ul class="nav nav-treeview">
                                @foreach ($item['children'] as $child)
                                    @php
                                        $childLabel = __('admin/menuleft.'.$child['key']);
                                        $childActive = ! empty($child['route']) && request()->routeIs($child['route']);
                                        $childHref = ! empty($child['route']) ? route($child['route']) : '#';
                                    @endphp
                                    <li class="nav-item">
                                        <a href="{{ $childHref }}" class="nav-link {{ $childActive ? 'active' : '' }}">
                                            <p>{{ $childLabel }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </li>

                @endforeach

            </ul>
        </nav>
    </div>

</aside>
