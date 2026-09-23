<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // อ้างอิงโครงสร้างองค์กร (org_id/department_id ผูก FK ทีหลังตอนมีตาราง organizations/departments จริง)
            $table->unsignedBigInteger('org_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();

            // Permission ผ่าน tbl_admin_group (ดู design.md หัวข้อ 2)
            $table->unsignedBigInteger('group_id')->nullable();

            $table->string('pic_user')->nullable();
            $table->string('activkey')->nullable();
            $table->timestamp('lastvisit_at')->nullable();

            // Flag ทั้งหมดเป็น tinyint: 1 = เปิด/ใช่, 0 = ปิด/ไม่ใช่
            $table->tinyInteger('superuser')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('online_status')->default(0);
            $table->tinyInteger('online_user')->default(0);
            $table->tinyInteger('del_status')->default(0);

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
