# Requirements: ระบบ ETS (e-Testing / e-Learning System)

## 1. ภาพรวมโครงการ

ระบบ ETS เป็นระบบ LMS + e-Testing ที่รองรับการเรียน การสอบออนไลน์ และการติดตามผลผู้เรียน
พัฒนาด้วย **Laravel 13** บน **PHP 8.5**, เชื่อมต่อ **PostgreSQL** (เครื่อง DB แยกจาก web server)

**บริบททีม:**
- ทีมมีคนเดียวทำหน้าที่ทั้ง PM และ Developer
- ทีมมีพื้นฐาน PHP/HTML/CSS/jQuery แบบดั้งเดิม ไม่มีคนถนัด Livewire/Vue/React
- ต้องการลดความซับซ้อนของ stack ให้มากที่สุด ใช้ ready-made package/tool แทนการเขียนเองทุกจุด
- ระบบต้องรองรับการทำเป็น "Package" หลายระดับ (เช่น Package A ตามภาพฟีเจอร์ที่ระบุ) เผื่อขายลูกค้าหลายเกรดในอนาคต — ควรออกแบบให้ฟีเจอร์เปิด/ปิดได้ผ่าน config ไม่ hardcode

## 2. Tech Stack ที่ตัดสินใจแล้ว

| Layer | เทคโนโลยี | หมายเหตุ |
|---|---|---|
| Backend Framework | Laravel 13 | ต้องการ PHP >= 8.3 (ใช้ 8.5 จริง) |
| PHP Runtime | PHP 8.5 (CLI + FPM) | เครื่อง web มี PHP 7.4 / 8.3 / 8.4 / 8.5 อยู่ร่วมกัน คนละ vhost/socket |
| Database | PostgreSQL | อยู่เครื่องแยก ต่อผ่าน network (`pdo_pgsql`), ไม่ได้ลง DB server บนเครื่อง web |
| Web Server | Apache 2.4 + PHP-FPM (proxy_fcgi) | หลาย vhost บนเครื่องเดียว แยก socket ตาม PHP version ต่อไซต์ |
| Admin Panel (หลังบ้าน) | **AdminLTE** (Bootstrap-based theme) | เปลี่ยนจาก Filament PHP v5 เดิม เพราะต้องคุม permission ต่อเมนูแบบ custom ตามระบบเก่า (ดูหัวข้อ Permission ด้านล่าง) ทีมเขียน CRUD/route/controller/view เอง ไม่มี resource generator ให้ |
| Frontend CSS (หน้าบ้าน + หลังบ้าน) | **Bootstrap 5** | เลือกเพราะ learning curve ต่ำ ไม่ต้อง build step บังคับ เข้ากับพื้นฐานทีม (HTML/jQuery) ใช้ร่วมกันได้ทั้งหน้าบ้านและหลังบ้าน (AdminLTE เป็น Bootstrap-based) ไม่มี Tailwind ในโปรเจกต์ |
| Realtime/Interactivity หน้าสอบ | **Alpine.js + Vanilla JS `fetch()`** | ทดแทน Livewire ที่ตัดออก ใช้สำหรับ timer, auto-submit, tab-switch detection |
| Permission (สิทธิ์การใช้งาน) | **Custom permission ผ่าน Laravel Gate (`can()`)** | ไม่ใช้ spatie/laravel-permission — คงโครงสร้างเดิมจากระบบเก่า: `tbl_admin_group` (กลุ่มสิทธิ์), `tbl_permission` (pivot group_id ↔ admin_menu_id), field `superuser` ใน users bypass ทุกอย่างไม่อิง role/group เลย เช็คผ่าน `Gate::define('menu', ...)` + custom Blade directive `@canmenu('1') ... @endcan` |
| จัดการไฟล์สื่อ (VDO/Audio/PDF) | spatie/laravel-medialibrary | |
| Log การใช้งานระบบ | spatie/laravel-activitylog | |
| ใบประกาศ (PDF) | barryvdh/laravel-dompdf | |
| Export รายงาน | maatwebsite/excel | |
| API | Laravel API Resource + Laravel Sanctum | token-based auth สำหรับเชื่อมระบบภายนอก |
| Notification/แจ้งเตือน | Laravel Notification + Queue (built-in) | |
| Localization (2 ภาษา) | Laravel built-in localization (`lang/th`, `lang/en`) | |

**สิ่งที่ตัดออกโดยตั้งใจ:** Livewire/Vue/React ฝั่ง frontend — ทีมไม่มีคนถนัด และมองว่าซับซ้อนเกินจำเป็นสำหรับ scope งานนี้

## 3. Functional Requirements (จากตาราง Package A)

| # | ฟีเจอร์ | Phase | หมายเหตุ |
|---|---|---|---|
| 1 | ระบบกำหนดสิทธิ์การใช้งาน | 0 | Permission ต่อเมนูผ่าน `tbl_admin_group`/`tbl_permission` (ดู Tech Stack), `superuser` bypass ทั้งหมด, บล็อก route ด้วย middleware ที่เช็คผ่าน Gate เดียวกัน, ซ่อนเมนูด้วย `@canmenu()` directive |
| 1.1 | ระบบ Idle Timeout (Auto Logout) | 0 | Middleware `checkIdleTimeout` — User 60 นาที, Admin 30 นาที (เข้มกว่าเพราะจัดการข้อมูลสมาชิก/สิทธิ์), หน้าห้องสอบไม่ whitelist แต่ fetch heartbeat นับเป็น activity เพื่อไม่ตัดตอนกำลังสอบ |
| 2 | ระบบจัดการสมาชิก (ผู้เรียนและระบบ) | 1 | |
| 3 | ระบบลงทะเบียนเรียน | 1 | Enrollment pivot ผูก user ↔ course |
| 4 | ระบบจัดการระดับขั้นการเรียน (Organization Course) | 1 | ต้องออกแบบ schema hierarchical/flat ให้ชัดก่อนเริ่ม |
| 5 | ระบบจัดการเนื้อหาบทเรียน (VDO, Audio, YouTube, PDF) | 2 | ใช้ spatie/laravel-medialibrary |
| 6 | ระบบคลังข้อสอบ | 3 | ต้องทำก่อนข้อ 7 เพราะแบบทดสอบดึงจากคลังนี้ |
| 7 | ระบบแบบสอบถามสำหรับใช้ภายนอก + รายงาน | 3 | |
| 8 | ระบบการติดตามผู้เรียน | 4 | |
| 9 | ระบบใบประกาศนียบัตร | 5 | Generate PDF จาก Blade template ผูกผลสอบ |
| 10 | ระบบการเก็บ LOG การใช้งานระบบ | 0 | ทำตั้งแต่ต้น hook เข้า auth/action layer ไว้เลย |
| 11 | ระบบรีเช็คผลการเรียนการสอบ | 4 | |
| 12 | ระบบตรวจสอบผู้เรียนระหว่างเรียน/สอบ | 3 | Anti-cheat MVP: screen snapshot + popup attention check (ไม่ทำ webcam) |
| 13 | ระบบแจ้งเตือนหมดเวลาเรียนไปยังอีเมล | 5 | Laravel Notification + Queue |
| 14 | ระบบห้องสอบออนไลน์ | 3 | ใช้ Blade + Alpine.js + fetch API (ไม่ใช้ Livewire), มี timer/auto-submit |
| 15 | ระบบแจ้งปัญหาการใช้งาน | 5 | |
| 16 | ระบบรายงาน (5 รายงาน) | 4 | ต้อง spec รายละเอียดแต่ละรายงานให้ชัดก่อนเริ่ม (filter/format/export) — รอลูกค้า |
| 17 | ระบบส่งผลการเรียนผ่านทางระบบโดยอัตโนมัติ | 4 | Queue-based, ต่อเนื่องจากข้อ 16 |
| 18 | การเข้าใช้งานแบบ Single Sign-On | 0/6 | ยังไม่ตัดสินใจ IdP — deferred |
| 19 | ระบบเชื่อมโยงข้อมูลรับเข้า-ส่งออก (API) | คู่ขนานทุก Phase | เขียน API resource ควบคู่ตอนทำแต่ละ module ไม่รวบทำท้ายสุด |
| 20 | ระบบจัดการเนื้อหาเว็บไซต์ (ข่าว/สาร) | 5 | CRUD ธรรมดา |
| 21 | ระบบคำถามที่พบบ่อย (FAQ) | 5 | CRUD ธรรมดา |
| 22 | การแสดงผล 2 ภาษา (ไทย/อังกฤษ) | 0 | ทำตั้งแต่ต้นระบบ ง่ายกว่ามาแปลทั้งระบบทีหลัง |

## 4. ลำดับการพัฒนา (Phase Plan)

- **Phase 0 — Foundation:** Auth scaffolding, Role (ข้อ 1), i18n (ข้อ 22), Logging middleware (ข้อ 10)
- **Phase 1 — สมาชิก + โครงสร้างคอร์ส:** ข้อ 2, 3, 4 — ออกแบบ ERD ให้แน่นก่อนเขียนโค้ด
- **Phase 2 — เนื้อหาบทเรียน:** ข้อ 5
- **Phase 3 — Assessment Engine:** ข้อ 6 → 7 → 14 → 12
- **Phase 4 — ติดตามผลและรายงาน:** ข้อ 8, 11, 16, 17
- **Phase 5 — Engagement/Support:** ข้อ 9, 13, 15, 20, 21
- **Phase 6 — Integration ที่เหลือ:** ข้อ 18, 19

## 5. Non-Functional Requirements

- **Performance:** เครื่อง UAT/Prod RAM 16GB, ต้องดูแล `memory_limit`/`pm.max_children` ของ PHP-FPM ไม่ให้กระทบเว็บอื่นบนเครื่องเดียวกัน
- **Security:** Route ต้องบล็อกตาม role ที่ middleware ระดับ route ไม่ใช่แค่ซ่อน UI เท่านั้น
- **Localization:** ทุกหน้าต้องรองรับ ไทย/อังกฤษ ตั้งแต่ตอนออกแบบ view
- **Maintainability:** ฟีเจอร์ต้องเปิด/ปิดได้ผ่าน config (เผื่อทำ Package B/C ในอนาคต)
- **Deployment:** Dev/UAT บน PHP 8.4/8.5 ตรงกับ Production เพื่อลด risk ตอน go-live

## 6. Open Questions

- [ ] **SSO (ข้อ 18)** — deferred, ยังไม่ตัดสินใจ IdP
- [ ] **5 รายงาน (ข้อ 16)** — deferred, รอ requirement จากลูกค้า
- [ ] **Schema จริงของ Permission system (ข้อ 1)** — ต้อง confirm: column ของ `tbl_admin_group`/`tbl_permission`/`tbl_admin_menu`, ผู้ใช้ผูกกับ group แบบ 1:1 หรือ many-to-many, ชื่อ column `superuser` ที่แน่นอน (ดู design.md หัวข้อ 2)
- [x] **ข้อ 12** — ปิดแล้ว: screen snapshot + popup attention check (ไม่ทำ webcam)
- [x] **โครงสร้าง Organization Course (ข้อ 4)** — ปิดแล้ว: คงรูปแบบเดิมจาก Yii1 — แนบหลักสูตรที่ node → มองเห็นได้จาก node นั้น + ทุก node สายล่างทั้งหมด (ดู design.md หัวข้อ 3.1)
- [x] **Admin Panel (ข้อ 1)** — ปิดแล้ว: เปลี่ยนจาก Filament v5 → AdminLTE เพราะต้องคุม permission ต่อเมนูแบบ custom
- [x] **Idle Timeout (ข้อ 1.1)** — ปิดแล้ว: User 60 นาที / Admin 30 นาที, heartbeat หน้าสอบนับเป็น activity (ดู design.md หัวข้อ 2.1)
