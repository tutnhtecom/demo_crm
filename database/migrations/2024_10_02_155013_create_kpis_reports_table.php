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
        Schema::create('kpis_reports', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('kpis_id')->unsigned()->nullable()->default(NULL)->comment('Lưu id của bảng kpis');
            $table->bigInteger('employees_id')->unsigned()->nullable()->default(NULL)->comment('Lưu id của bảng kpis');
            $table->bigInteger('leads_id')->unsigned()->nullable()->default(NULL)->comment('Lưu id của bảng kpis');
            $table->double('price')->nullable()->default(0)->comment('Lưu id của bảng kpis');
            $table->date('date_for_price')->nullable()->default(NULL)->comment('Lưu ngày đóng tiếng học của sinh viên');            
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
            $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
            $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ'); 
            
            // $table->foreign('kpis_id')->references('id')->on('kpis')->onDelete('cascade');
            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('leads_id')->references('id')->on('leads')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpis_reports');
    }
};
