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
        if(!Schema::hasTable('custom_fields_imports')) {
            Schema::create('custom_fields_imports', function (Blueprint $table) {
                $table->id()->comment('Lưu id tự sinh sau khi thêm bản ghi');
                $table->string('code')->nullable(TRUE)->default(NULL)->comment('Lưu key được định nghĩa sẵn');
                $table->string('name')->nullable(TRUE)->default(NULL)->comment('Lưu tên trường bổ sung');
                $table->string('slug')->nullable(TRUE)->default(NULL)->comment('Lưu slug từ trường name');
                $table->string('types')->nullable(TRUE)->default(NULL)->comment('Lưu loại đối tượng cus_field: 0: leads, 1: student, 2: employee');
                $table->timestamps();
                $table->softDeletes();
                $table->bigInteger('created_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người tạo mới');
                $table->bigInteger('updated_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người cập nhật');
                $table->bigInteger('deleted_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người xóa bỏ');
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_fields_leads');
    }
};
