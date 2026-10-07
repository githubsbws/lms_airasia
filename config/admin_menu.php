<?php

/**
 * โครงสร้างเมนูซ้ายของ Admin Panel (AdminLTE sidebar)
 *
 * แต่ละรายการ:
 *   - id       : ตรงกับ admin_menu.id ใน DB (ใช้เช็คสิทธิ์ผ่าน PermissionHelper::canMenu()
 *                / @canmenu directive) ถ้าไม่ตั้งไว้ = ไม่เช็ค permission เห็นได้ทุกคน
 *   - key      : ใช้ดึงคำแปลจาก lang/{locale}/admin/menuleft.php ผ่าน __("admin/menuleft.$key")
 *   - icon     : Bootstrap Icons class (bi-*)
 *   - route    : ชื่อ route (Route::name) — ถ้ายังไม่มีหน้าจริง ใส่ null แล้วจะ render เป็น href="#"
 *   - children : เมนูย่อย (ถ้ามี จะ render เป็น treeview ของ AdminLTE)
 *
 * หมายเหตุ: id อ้างอิงจากตาราง admin_menu จริงใน DB (ดู design.md หัวข้อ 2)
 * ใช้คู่กับ Gate::define('menu', ...) + @canmenu() directive เพื่อกรองเมนูตาม
 * group ของผู้ใช้ และ superuser จะเห็นทุกเมนูเสมอ (ดู App\Helpers\PermissionHelper)
 */

return [

    [
        'id' => 1,
        'key' => 'home',
        'icon' => 'bi-house-door',
        'route' => 'admin.home',
    ],

    [
        'id' => 4,
        'key' => 'setting',
        'icon' => 'bi-gear-fill',
        'route' => null,
    ],

    [
        'id' => 5,
        'key' => 'about_us',
        'icon' => 'bi-info-lg',
        'route' => null,
    ],

    [
        'id' => 6,
        'key' => 'condition',
        'icon' => 'bi-gear-fill',
        'route' => null,
    ],

    [
        'id' => 7,
        'key' => 'contact_us',
        'icon' => 'bi-people',
        'route' => null,
    ],

    [
        'id' => 8,
        'key' => 'news_management',
        'icon' => 'bi-newspaper',
        'route' => null,
    ],

    [
        'id' => 9,
        'key' => 'catagory',
        'icon' => 'bi-bookmark-fill',
        'route' => null,
        'badge' => 1,
    ],

    [
        'id' => 10,
        'key' => 'course',
        'icon' => 'bi-book-fill',
        'route' => null,
        'badge' => 2,
    ],

    [
        'id' => 11,
        'key' => 'lesson',
        'icon' => 'bi-collection-play-fill',
        'route' => null,
        'badge' => 3,
    ],

    [
        'id' => 12,
        'key' => 'exam',
        'icon' => 'bi-pencil-square',
        'route' => null,
        'badge' => 4,
    ],

    [
        'id' => 13,
        'key' => 'training_evaluate',
        'icon' => 'bi-clipboard-check-fill',
        'route' => null,
        'badge' => 5,
    ],

    [
        'id' => 14,
        'key' => 'course_reset',
        'icon' => 'bi-arrow-counterclockwise',
        'route' => null,
    ],

    [
        'id' => 15,
        'key' => 'organization_management',
        'icon' => 'bi-diagram-3-fill',
        'route' => null,
    ],

    [
        'id' => 16,
        'key' => 'how_to',
        'icon' => 'bi-question-circle-fill',
        'route' => null,
    ],

    [
        'id' => 17,
        'key' => 'faq',
        'icon' => 'bi-patch-question-fill',
        'route' => null,
    ],

    [
        'id' => 18,
        'key' => 'permission',
        'icon' => 'bi-shield-lock-fill',
        'route' => null,
        'children' => [
            ['key' => 'admin_group', 'route' => 'admin.permission.group'],
            ['key' => 'admin_permission_menu', 'route' => null],
        ],
    ],

    [
        'id' => 19,
        'key' => 'document',
        'icon' => 'bi-file-earmark-text-fill',
        'route' => null,
    ],

    [
        'id' => 20,
        'key' => 'vdo',
        'icon' => 'bi-camera-video-fill',
        'route' => null,
    ],

    [
        'id' => 21,
        'key' => 'advertise_image',
        'icon' => 'bi-image-fill',
        'route' => null,
    ],

    [
        'id' => 22,
        'key' => 'information',
        'icon' => 'bi-megaphone-fill',
        'route' => null,
    ],

    [
        'id' => 23,
        'key' => 'private_message',
        'icon' => 'bi-chat-dots-fill',
        'route' => null,
    ],

    [
        'id' => 24,
        'key' => 'member_management',
        'icon' => 'bi-people-fill',
        'route' => null,
    ],

    [
        'id' => 25,
        'key' => 'issue_report',
        'icon' => 'bi-exclamation-triangle-fill',
        'route' => null,
    ],

    // [
    //     'key' => 'orgchart',
    //     'icon' => 'bi-question-circle-fill',
    //     'route' => null,
    // ],

    [
        'id' => 27,
        'key' => 'lesson_notification',
        'icon' => 'bi-bell-fill',
        'route' => null,
    ],

    [
        'id' => 28,
        'key' => 'tracking',
        'icon' => 'bi-graph-up-arrow',
        'route' => null,
    ],

    [
        'id' => 29,
        'key' => 'report',
        'icon' => 'bi-bar-chart-fill',
        'route' => null,
    ],

    // [
    //     'key' => 'certificate',
    //     'icon' => 'bi-patch-check-fill',
    //     'route' => null,
    // ],

    [
        'id' => 31,
        'key' => 'captcha',
        'icon' => 'bi-shield-check',
        'route' => null,
    ],

    [
        'id' => 32,
        'key' => 'group',
        'icon' => 'bi-building',
        'route' => null,
    ],

    [
        'id' => 33,
        'key' => 'station',
        'icon' => 'bi-building',
        'route' => null,
    ],

    [
        'id' => 34,
        'key' => 'section',
        'icon' => 'bi-building',
        'route' => null,
    ],

    [
        'id' => 35,
        'key' => 'department',
        'icon' => 'bi-building',
        'route' => null,
    ],

    [
        'id' => 36,
        'key' => 'position',
        'icon' => 'bi-building',
        'route' => null,
    ],

    [
        'id' => 37,
        'key' => 'results_to_mail',
        'icon' => 'bi-envelope-fill',
        'route' => null,
    ],

    [
        'id' => 38,
        'key' => 'system_log',
        'icon' => 'bi-journal-text',
        'route' => null,
    ],

];
