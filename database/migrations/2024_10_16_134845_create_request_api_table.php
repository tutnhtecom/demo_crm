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
        Schema::create('api_lists', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->nullable(false)->comment('Lưu tên của api');   
            $table->string('request_url')->nullable(false)->comment('Lưu địa chỉ url khi request api');
            $table->string('method_name')->nullable(false)->comment('Lưu tên của phương thức request');                                    
            $table->text('body')->nullable(false)->comment('Lưu data request');      
            $table->string('controller_name')->nullable(TRUE)->default(NULL)->comment('Lưu tên controller khi gọi api');
            $table->string('action_name')->nullable(TRUE)->default(NULL)->comment('Lưu action khi gọi api');            
            $table->string('auth_type')->nullable(TRUE)->default(NULL)->comment('Lưu kiểu đăng nhập');                  
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
        Schema::dropIfExists('request_api');
    }
};
