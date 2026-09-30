# ETS (E-Learning System)

ระบบ LMS + e-Testing พัฒนาด้วย Laravel 13 บน PHP 8.5 เชื่อมต่อ PostgreSQL

รายละเอียด requirement และ design เต็มอยู่ที่ `.kiro/specs/ets-lms/requirements.md` และ `.kiro/specs/ets-lms/design.md`

## Requirements

- PHP >= 8.3 (ใช้จริงที่ PHP 8.5) — เครื่อง dev มีหลายเวอร์ชันของ PHP ติดตั้งอยู่ ต้องเรียกใช้ผ่าน path เต็มของ PHP 8.5 เสมอ (`C:\php-8.5.10\php.exe`) ห้ามใช้คำสั่ง `php` เปล่าๆ เพราะ PATH ชี้ไปที่เวอร์ชันต่ำกว่าที่โปรเจกต์ต้องการ
- Composer
- Node.js + npm
- PostgreSQL

## ติดตั้งครั้งแรก

```powershell
หากเครื่องยังไม่มี ให้ลง compoers จากเว็บก่อน 
php8.5 ควรลงที่ c:/php8.5 
composer install (หากมี php >= 2 version ต้องใช้ php8.5 ในการสั่งรัน programdata/composer/composer.phar ** path อาจจะไม่ตรง)
npm install
```

ตั้งค่าการเชื่อมต่อ PostgreSQL ใน `.env` ให้ตรงกับเครื่อง DB ที่ใช้งาน

## รันตอน Dev

เปิด 2 terminal แล้วรันคู่กัน:

**Terminal 1 — Laravel server (ผ่าน `s.bat`):**

```powershell
.\s.bat
```

`s.bat` จะรัน `php artisan serve` ด้วย PHP 8.5.10 ให้อัตโนมัติ (ไม่ต้องพิมพ์ `php` เอง)

**Terminal 2 — Vite dev server (hot reload):**

```powershell
npm run dev
```

จำเป็นต้องรัน `npm run dev` ควบคู่ด้วยเสมอ ไม่งั้นจะเจอ error `Vite manifest not found` เพราะหน้าเว็บหา asset ที่ build แล้วไม่พบ

## Deploy ขึ้น Production

Build asset ให้เป็นไฟล์ static ก่อน (ไม่ใช้ dev server):

```powershell
npm run build
```

คำสั่งนี้จะสร้าง `public/build/manifest.json` และไฟล์ asset ที่ minify แล้ว ใช้แทนการรัน `npm run dev` บนเครื่อง production

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
