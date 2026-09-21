# Design: ระบบ ETS (e-Testing / e-Learning System)

## 1. สถาปัตยกรรมโดยรวม

Apache 2.4 (proxy_fcgi) → แยก 2 ปีก:
- Frontend (หน้าบ้าน): Blade + Bootstrap 5 + Alpine.js (เฉพาะหน้าห้องสอบ)
- Admin Panel (หลังบ้าน): **AdminLTE** (Bootstrap-based theme, mount ที่ /admin, ใช้ Bootstrap 5 ร่วมกับหน้าบ้านได้ ไม่ต้องมี Tailwind ในโปรเจกต์) — **เปลี่ยนจาก Filament PHP v5 เดิม** เพราะต้องคุม permission ต่อเมนูแบบ custom ตามระบบเก่า ซึ่ง Filament ไม่รองรับ pattern นี้ตรงๆ และทีมต้องเขียน CRUD/route/controller/view เองทุกโมดูล (ไม่มี resource generator ให้แบบ Filament)

ทั้งหมดรันบน Laravel 13 + PHP 8.5-FPM → เชื่อมต่อ PostgreSQL ที่อยู่เครื่องแยก (network)

## 2. Authentication & Authorization

- Laravel Breeze เป็น auth scaffold เริ่มต้น
- **ไม่ใช้ spatie/laravel-permission** — เปลี่ยนเป็น custom permission system คงโครงสร้างเดิมจากระบบเก่า:
  - `tbl_admin_group` — กลุ่มสิทธิ์ (group ของผู้ใช้งานฝั่ง admin)
  - `tbl_permission` — pivot เก็บว่า group ไหนเห็นเมนูไหนได้ (`group_id`, `admin_menu_id`)
  - `tbl_admin_menu` (หรือชื่อเทียบเท่า) — ตารางเมนูทั้งหมดของระบบ
  - `users`/`tbl_users` มี field `superuser` (boolean/tinyint) — ถ้า `superuser = 1` **bypass การเช็ค permission ทั้งหมด** ไม่อิง role/group เลย
- เช็คสิทธิ์ผ่าน **Laravel Gate (`can()`)** ไม่ใช้ role-based directive แบบเดิม:
  - `Gate::before()` ใน `AppServiceProvider::boot()` — เช็ค `superuser` bypass ก่อนเสมอ
  - `Gate::define('menu', ...)` — รับ `menu_id` ไปเทียบกับ `tbl_permission` ผ่าน group ของ user ปัจจุบัน
  - Custom Blade directive `@canmenu('1') ... @endcan` — wrapper สั้นๆเรียก Gate `menu` ข้างหลัง (สำหรับซ่อน/แสดงเมนูใน view)
  - กันเข้าลิงก์ตรง (route level): middleware ที่เช็คผ่าน Gate เดียวกัน ไม่ใช่แค่ซ่อน UI เท่านั้น
- Redirect เมื่อไม่มีสิทธิ์: custom exception handler กลับ dashboard ตัวเอง
- SSO: เตรียม abstraction ไว้ที่ AuthServiceProvider/guard config, รอ confirm IdP
- **รอ confirm schema จริง** ก่อน implement: column ของ `tbl_admin_group`/`tbl_permission`/`tbl_admin_menu`, ผู้ใช้ผูกกับ group แบบ 1:1 (column `group_id` ตรงในตัว) หรือ many-to-many ผ่าน pivot, ชื่อ column `superuser` ที่แน่นอน

## 2.1 Idle Timeout (Auto Logout)

- Middleware `CheckIdleTimeout` (alias: `checkIdleTimeout`) — ผูกกับ route แบบ `->middleware('checkIdleTimeout')`
- ทำงานโดยเก็บ timestamp กิจกรรมล่าสุดไว้ใน session (`last_activity_at`) ทุก request ที่ผ่าน middleware
- ถ้า idle เกินเวลาที่กำหนด → `Auth::logout()` + invalidate session + redirect ไปหน้า login พร้อม flash message
- **ระยะเวลา idle timeout (ปรับได้ผ่าน config/env ไม่ hardcode):**
  - ฝั่ง User (หน้าบ้าน): **60 นาที**
  - ฝั่ง Admin (หลังบ้าน): **30 นาที** — เข้มกว่าเพราะจัดการข้อมูลสมาชิก/สิทธิ์/ข้อสอบ
- **หน้าห้องสอบ (`course-exam`, `exam`) ไม่ whitelist ออกจาก idle timeout** — แต่ให้ fetch heartbeat (sync ทุก 30-60 วิ ตามข้อ 4) เขียน `last_activity_at` ทับด้วยทุกครั้ง เพื่อไม่ตัดตอนขณะทำข้อสอบจริง แต่ยัง auto logout ได้ถ้าผู้ใช้ปิดเบราว์เซอร์/เดินจากไปจริง (heartbeat หยุดส่ง)

## 3. Data Model หลัก (ร่างเริ่มต้น)

- users: id, name, email, password, role, language_pref
- organizations: id, name, parent_id, order, path (tree, คงตาม Yii1)
- courses: id, title, description, status
- course_organization: id, course_id, organization_id (pivot จุดที่แนบหลักสูตร)
- enrollments: id, user_id, course_id, status, enrolled_at, progress
- lesson_contents: id, course_id, type (vdo/audio/youtube/pdf), media, order
- question_bank: id, category, question_text, type, choices(json), correct_answer
- exams: id, course_id, title, duration_minutes, question_ids, is_public
- exam_attempts: id, exam_id, user_id, started_at, submitted_at, score, status, proctor_log
- certificates: id, user_id, course_id, exam_attempt_id, issued_at, file_path
- activity_log: (จาก spatie/laravel-activitylog)
- notifications: (Laravel built-in)
- announcements / faqs: id, title, body(i18n), status

## 3.1 Logic การมองเห็นหลักสูตรตามโครงสร้างองค์กร (ข้อ 4 — คงตาม Yii1 เดิม)

**Requirement:** สร้างหลักสูตร → เข้าหน้า Organization (tree) → เลือก node ที่จะแนบหลักสูตร →
หลักสูตรมองเห็นได้จาก node นั้น + ทุก node สายล่าง (descendants) ทั้งหมด (cascade ลงล่างอย่างเดียว)

**แนวทาง implement:**
- organizations เป็น tree ผ่าน parent_id (adjacency list) — พิจารณาเสริม materialized path หรือ `kalnoy/nestedset` เพื่อ query descendants เร็ว
- course_organization (pivot) เก็บว่าหลักสูตรแนบที่ node ไหน
- Query "หลักสูตรที่มองเห็นได้จาก node X" = หลักสูตรที่แนบที่ X เอง หรือที่ ancestor ใดๆของ X
- **สำคัญ:** ต้องขอดู schema/โค้ดเดิมของ Yii1 ก่อน implement จริง เพื่อคงพฤติกรรมเดิม 100% (เช็ค edge case: แนบได้หลาย node พร้อมกันไหม, node inactive มีผลยังไง)

## 4. ระบบห้องสอบออนไลน์ (ข้อ 14) — แทน Livewire

Flow:
1. กด "เข้าสอบ" → สร้าง exam_attempt, คืนข้อมูลคำถาม+เวลาเป็น JSON
2. Blade render + Alpine.js component เก็บ state
3. Alpine.js `setInterval` นับเวลาถอยหลัง + sync heartbeat ทุก 30-60 วิ ผ่าน fetch()
4. Auto-save คำตอบทุกครั้งที่ตอบ ผ่าน fetch() POST
5. หมดเวลา → auto-submit ผ่าน fetch()
6. Proctoring MVP (ข้อ 12): screen snapshot เป็นระยะ + popup attention check + tab-switch detection (`visibilitychange` event) → เก็บ log ที่ตาราง proctor_events แยก (ไม่เก็บไฟล์ใน JSON column)

## 5. Frontend Structure (Bootstrap 5)

resources/views/layouts/mainlayout.blade.php (layout หลัก)
resources/views/frontend/{dashboard, courses, exam, certificates, announcements, faq}
resources/lang/{th, en}

ใช้ Bootstrap 5 ผ่าน CDN เป็นค่าเริ่มต้น (ลด build pipeline บนเครื่อง UAT/Prod)
Component ที่ใช้ซ้ำทำเป็น Blade component (`<x-course-card>` ฯลฯ)

## 6. API Layer (ข้อ 19)

- Laravel API Resource คู่กับแต่ละ module
- Auth ผ่าน Laravel Sanctum
- Versioning: `/api/v1/...`

## 7. Deployment Topology

- Web/Apache: หลาย vhost, PHP 7.4/8.3/8.4/8.5 แยก socket ต่อไซต์ — โปรเจกต์นี้ใช้ php8.5-fpm.sock
- DB server: PostgreSQL แยกเครื่อง, เปิด pg_hba.conf/firewall ให้ web server เข้าถึง
- Git workflow: Dev PC → push Git → clone/pull UAT → composer install --no-dev → migrate → cache clear
