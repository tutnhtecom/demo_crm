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
        if(!Schema::hasTable('leads_academic_terms'))     {
            Schema::create('leads_academic_terms', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('leads_id')->unsigned()->nullable(false)->comment('Lưu ID của sinh viên');                
                $table->bigInteger('academic_terms_id')->unsigned()->nullable(false)->comment('Lưu id của niên khóa');
                $table->timestamps();
                $table->softDeletes();                
                $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
                $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
                $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');
                $table->foreign('leads_id')->references('id')->on('leads')->onDelete('cascade');
                $table->foreign('academic_terms_id')->references('id')->on('academic_terms')->onDelete('cascade');                
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads_academic_terms');
    }
};
