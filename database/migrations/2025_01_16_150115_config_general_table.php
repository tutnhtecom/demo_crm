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
        if(!Schema::hasTable('config_generals')) {
            Schema::create('config_generals', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable(TRUE)->default(NULL)->comment('Lưu tiêu đề của cấu hình');
                $table->tinyInteger('types')->nullable(TRUE)->default(0)->comment('Lưu types của cấu hình');
                $table->integer('start_date')->nullable(TRUE)->default(NULL)->comment('Lưu số ngày bắt đầu');
                $table->integer('end_date')->nullable(TRUE)->default(NULL)->comment('Lưu ngày kết thúc');
                $table->string('current_month', 20)->nullable(TRUE)->default(NULL)->comment('Lưu tháng hiện tại');    
                $table->bigInteger('created_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người tạo');
                $table->bigInteger('updated_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người sửa');
                $table->bigInteger('deleted_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người xóa');
                $table->timestamps();
                $table->softDeletes();
            });

        }
    }
    public function down(): void
    {
        if(!Schema::hasTable('config_generals')) {
            Schema::create('config_generals', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable(TRUE)->default(NULL)->comment('Lưu tiêu đề của cấu hình');
                $table->tinyInteger('types')->nullable(TRUE)->default(0)->comment('Lưu types của cấu hình');
                $table->integer('start_date')->nullable(TRUE)->default(NULL)->comment('Lưu số ngày bắt đầu');
                $table->integer('end_date')->nullable(TRUE)->default(NULL)->comment('Lưu ngày kết thúc');
                $table->string('current_month', 20)->nullable(TRUE)->default(NULL)->comment('Lưu tháng hiện tại');    
                $table->bigInteger('created_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người tạo');
                $table->bigInteger('updated_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người sửa');
                $table->bigInteger('deleted_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người xóa');
                $table->timestamps();
                $table->softDeletes();
            });

        }
    }
};
