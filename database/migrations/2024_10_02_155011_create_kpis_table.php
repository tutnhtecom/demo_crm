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
        Schema::create('kpis', function (Blueprint $table) {
            $table->id();    
            $table->bigInteger('employees_id')->unsigned()->nullable()->comment('Lưu id của nhân viên');                    
            $table->double('price')->nullable(false)->comment('Lưu mô tả của kpis');                        
            $table->integer('quantity')->nullable(false)->comment('Lưu mục tiêu của kpi (số ngày)');            
            $table->date('from_date')->nullable(false)->comment('Lưu ngày bắt đầu thực hiện của kpis');            
            $table->date('to_date')->nullable(false)->comment('Lưu ngày kết thúc thực hiện kpis');            
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
            $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
            $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');

            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpis');
    }
};
