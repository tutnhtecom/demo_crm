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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employees_id')->unsigned()->nullable(FALSE)->comment('Lưu id của nhân viên');
            $table->string('name')->nullable(false)->comment('Lưu tên công việc của task');                        
            $table->text('description')->nullable()->default(NULL)->comment('Lưu mô tả của task');                        
            $table->date('from_date')->nullable(false)->comment('Lưu ngày bắt đầu của sự kiện');
            $table->date('to_date')->nullable(FALSE)->comment('Lưu thời gian kết thúc của sự kiện');            
            $table->tinyInteger('status')->nullable()->comment('Trạng thái');  
            $table->tinyInteger('priority')->nullable()->comment('Lưu độ ưu tiên của công việc');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
            $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
            $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');
            
            //Quan hệ với bảng provinces
            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
