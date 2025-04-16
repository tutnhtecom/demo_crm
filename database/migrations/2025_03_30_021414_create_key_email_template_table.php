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
        if(!Schema::hasTable('email_template_key')) {
            Schema::create('email_template_key', function (Blueprint $table) {
                $table->id();
                $table->string('display_name')->nullable(false)->comment('Lưu giá trị hiển thị của tên ');
                $table->string('default_key')->nullable(false)->comment('Lưu gia tri hiển thị của key mặc định');
                $table->string('customs_key')->nullable(true)->default(NULL)->comment('Lưu gia tri hiển thị của key tuỳ chỉnh');
                $table->tinyInteger('types')->nullable(TRUE)->default(0)->comment('Lưu giá trị đối tượng lưu: 0 Sinh viên, 1 SVTN, 2, Nhan su');                
                $table->timestamps();
                $table->softDeletes();
                $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
                $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
                $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(!Schema::hasTable('email_template_key')) {
            Schema::create('email_template_key', function (Blueprint $table) {
                $table->id();
                $table->string('display_name')->nullable(false)->comment('Lưu giá trị hiển thị của tên ');
                $table->string('default_key')->nullable(false)->comment('Lưu gia tri hiển thị của key mặc định');
                $table->string('customs_key')->nullable(true)->default(NULL)->comment('Lưu gia tri hiển thị của key tuỳ chỉnh');
                $table->tinyInteger('types')->nullable(TRUE)->default(0)->comment('Lưu giá trị đối tượng lưu: 0 Sinh viên, 1 SVTN, 2, Nhan su');                
                $table->timestamps();
                $table->softDeletes();
                $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
                $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
                $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');
            });
        }
    }
};
