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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();            
            $table->string('name')->nullable(FALSE)->comment('Lưu họ và tên nhân viên');
            $table->string('slug')->nullable(FALSE)->comment('Lưu slug nhân viên');
            $table->bigInteger('parent_id')->nullable(TRUE)->default(NULL)->comment('Lưu pemission id cha');           
            $table->string('router_name')->nullable(TRUE)->default(NULL)->comment('Lưu router name');                    
            $table->string('display_name')->nullable(TRUE)->default(NULL)->comment('Lưu display name');
            $table->string('class_name')->nullable(TRUE)->default(NULL)->comment('Lưu class name');
            $table->string('action_name')->nullable(TRUE)->default(NULL)->comment('Lưu action name');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
            $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
            $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
