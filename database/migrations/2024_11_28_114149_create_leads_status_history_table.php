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
        Schema::create('lst_status_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('leads_id')->unsigned()->nullable(TRUE)->default(NULL)->comment('Lưu id sinh viên tiềm năng');
            $table->bigInteger('students_id')->unsigned()->nullable(TRUE)->default(NULL)->comment('Lưu id sinh viên chính thức');
            $table->bigInteger('lst_status_id')->unsigned()->nullable(TRUE)->default(NULL)->comment('Lưu id của trạng thái');            
            $table->bigInteger('created_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người tạo');
            $table->bigInteger('updated_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người sửa');
            $table->bigInteger('deleted_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người xóa');            
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('leads_id')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('students_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('lst_status_id')->references('id')->on('lst_status')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lst_status_history');
    }
};
