<?php

/**
 * โครงสร้างเมนูซ้ายของ Admin Panel (AdminLTE sidebar)
 *
 * แต่ละรายการ:
 *   - key      : ใช้ดึงคำแปลจาก lang/{locale}/admin/menuleft.php ผ่าน __("admin/menuleft.$key")
 *   - icon     : Bootstrap Icons class (bi-*)
 *   - route    : ชื่อ route (Route::name) — ถ้ายังไม่มีหน้าจริง ใส่ null แล้วจะ render เป็น href="#"
 *   - children : เมนูย่อย (ถ้ามี จะ render เป็น treeview ของ AdminLTE)
 *
 * หมายเหตุ: โครงนี้เป็นค่าคงที่ระดับระบบก่อน (ยังไม่ผูก permission จริง)
 * ต่อไปจะเชื่อมกับ tbl_admin_menu/tbl_permission ตาม design.md หัวข้อ 2
 * (Gate::define('menu', ...) + @canmenu() directive) เพื่อกรองเมนูตาม group
 * ของผู้ใช้ และ superuser จะเห็นทุกเมนูเสมอ
 */

return [

    [
        'key' => 'home',
        'icon' => 'bi-speedometer2',
        'route' => 'admin.home',
    ],

    [
        'key' => 'member_management',
        'icon' => 'bi-people-fill',
        'route' => null,
    ],

    [
        'key' => 'organization_management',
        'icon' => 'bi-diagram-3-fill',
        'route' => null,
        'children' => [
            ['key' => 'orgchart', 'route' => null],
            ['key' => 'group', 'route' => null],
            ['key' => 'station', 'route' => null],
            ['key' => 'section', 'route' => null],
            ['key' => 'department', 'route' => null],
            ['key' => 'position', 'route' => null],
        ],
    ],

    [
        'key' => 'catagory',
        'icon' => 'bi-bookmark-fill',
        'route' => null,
    ],

    [
        'key' => 'course',
        'icon' => 'bi-book-fill',
        'route' => null,
    ],

    [
        'key' => 'lesson',
        'icon' => 'bi-collection-play-fill',
        'route' => null,
    ],

    [
        'key' => 'exam',
        'icon' => 'bi-pencil-square',
        'route' => null,
    ],

    [
        'key' => 'training_evaluate',
        'icon' => 'bi-clipboard-check-fill',
        'route' => null,
    ],

    [
        'key' => 'course_reset',
        'icon' => 'bi-arrow-counterclockwise',
        'route' => null,
    ],

    [
        'key' => 'tracking',
        'icon' => 'bi-graph-up-arrow',
        'route' => null,
    ],

    [
        'key' => 'certificate',
        'icon' => 'bi-patch-check-fill',
        'route' => null,
    ],

    [
        'key' => 'report',
        'icon' => 'bi-bar-chart-fill',
        'route' => null,
    ],

    [
        'key' => 'results_to_mail',
        'icon' => 'bi-envelope-fill',
        'route' => null,
    ],

    [
        'key' => 'lesson_notification',
        'icon' => 'bi-bell-fill',
        'route' => null,
    ],

    [
        'key' => 'news_management',
        'icon' => 'bi-newspaper',
        'route' => null,
    ],

    [
        'key' => 'document',
        'icon' => 'bi-file-earmark-text-fill',
        'route' => null,
    ],

    [
        'key' => 'vdo',
        'icon' => 'bi-camera-video-fill',
        'route' => null,
    ],

    [
        'key' => 'advertise_image',
        'icon' => 'bi-image-fill',
        'route' => null,
    ],

    [
        'key' => 'information',
        'icon' => 'bi-megaphone-fill',
        'route' => null,
    ],

    [
        'key' => 'private_message',
        'icon' => 'bi-chat-dots-fill',
        'route' => null,
    ],

    [
        'key' => 'how_to',
        'icon' => 'bi-question-circle-fill',
        'route' => null,
    ],

    [
        'key' => 'faq',
        'icon' => 'bi-patch-question-fill',
        'route' => null,
    ],

    [
        'key' => 'issue_report',
        'icon' => 'bi-exclamation-triangle-fill',
        'route' => null,
    ],

    [
        'key' => 'permission',
        'icon' => 'bi-shield-lock-fill',
        'route' => null,
    ],

    [
        'key' => 'system_log',
        'icon' => 'bi-journal-text',
        'route' => null,
    ],

    [
        'key' => 'captcha',
        'icon' => 'bi-shield-check',
        'route' => null,
    ],

    [
        'key' => 'setting',
        'icon' => 'bi-gear-fill',
        'route' => null,
        'children' => [
            ['key' => 'about_us', 'route' => null],
            ['key' => 'condition', 'route' => null],
            ['key' => 'contact_us', 'route' => null],
        ],
    ],

];
