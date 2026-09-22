{{-- =========================================================
| Footer: ฝั่ง Admin (หลังบ้าน)
| แยกไว้ในโฟลเดอร์ admin โดยเฉพาะ ไม่ปนกับหน้าบ้าน
| ใช้ร่วมกับ resources/views/admin/layouts/mainlayout.blade.php
========================================================== --}}
<footer class="bg-light border-top py-3 mt-auto">
    <div class="container-fluid">
        <p class="mb-0 text-muted text-center text-md-start">
            &copy; {{ date('Y') }} {{ config('app.name', 'ETS') }} — Admin Panel
        </p>
    </div>
</footer>
