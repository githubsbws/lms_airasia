// Bootstrap 5 JS bundle (รวม Popper) — dropdown, modal, collapse ฯลฯ
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// AdminLTE 4 JS — sidebar treeview, push-menu, layout fixer ฯลฯ
import 'admin-lte/dist/js/adminlte.js';

// Tabulator — ตารางที่มี search/sort/pagination ในตัว ไม่พึ่ง jQuery
// ต้อง import ผ่านไฟล์นี้เท่านั้น (Vite bundle ให้) เพราะ inline
// <script> ในไฟล์ Blade ไม่รู้จัก bare import specifier อย่าง
// "tabulator-tables" ได้เอง (ต้องเป็น URL/relative path จริงเท่านั้น)
import { TabulatorFull as Tabulator } from 'tabulator-tables';

window.Tabulator = Tabulator;

// ยิง event บอกว่า admin.js (รวม Tabulator) พร้อมใช้งานแล้ว — หน้าที่ต้อง
// ใช้ Tabulator ให้ listen event นี้ก่อนสร้างตาราง แทนการเดาจังหวะเอาเอง
// (module script โหลดแบบ deferred ไม่การันตีว่าจะเสร็จก่อน inline script
// อื่นที่ไม่ใช่ type="module" รัน จึงพึ่ง window.Tabulator ตรงๆไม่ได้)
window.dispatchEvent(new Event('admin-scripts-ready'));
