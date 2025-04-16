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
        if(!Schema::hasTable('report_price_lists_by_sources')) {
            Schema::create('report_price_lists_by_sources', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('sources_id')->nullable(TRUE)->default(NULL)->comment('Lưu id của đối tác liên kết'); // DVLK
                $table->string('sources_name')->nullable(TRUE)->default(NULL)->comment('Luu ten cuar DVLK');// DVLK
                $table->bigInteger('students_id')->nullable(TRUE)->default(NULL)->comment('Luu id cua sinh vien'); // sinh vien
                $table->string('students_name')->nullable(TRUE)->default(NULL)->comment('Luu ten cua sinh vien'); // sinh vien
                $table->string('students_code')->nullable(TRUE)->default(NULL)->comment('Luu ten cua sinh vien'); // sinh vien
                $table->bigInteger('acedemic_term_id')->nullable(TRUE)->default(NULL)->comment('Lưu id cua nien khoa'); // Nien khoa
                $table->string('acedemic_term_name')->nullable(TRUE)->default(NULL)->comment('Lưu ten cua nien khoa'); // Nien khoa
                $table->bigInteger('marjors_id')->nullable(TRUE)->default(NULL)->comment('Lưu id cua nganh hoc'); // Nganh hoc
                $table->string('marjors_name')->nullable(TRUE)->default(NULL)->comment('Lưu ten cua nganh hoc'); // Nganh hoc
                $table->text('price_lists')->nullable(TRUE)->default(NULL)->comment('Lưu ten cua nganh hoc'); // Hoc ky
                $table->bigInteger('created_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người tạo');
                $table->bigInteger('updated_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người sừa');
                $table->bigInteger('deleted_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người xóa');                
                $table->timestamps();
                $table->softDeletes();                
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(!Schema::hasTable('report_price_lists_by_sources')) {
            Schema::create('report_price_lists_by_sources', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('sources_id')->nullable(TRUE)->default(NULL)->comment('Lưu id của đối tác liên kết'); // DVLK
                $table->string('sources_name')->nullable(TRUE)->default(NULL)->comment('Luu ten cuar DVLK');// DVLK
                $table->bigInteger('students_id')->nullable(TRUE)->default(NULL)->comment('Luu id cua sinh vien'); // sinh vien
                $table->string('students_name')->nullable(TRUE)->default(NULL)->comment('Luu ten cua sinh vien'); // sinh vien
                $table->string('students_code')->nullable(TRUE)->default(NULL)->comment('Luu ten cua sinh vien'); // sinh vien
                $table->bigInteger('acedemic_term_id')->nullable(TRUE)->default(NULL)->comment('Lưu id cua nien khoa'); // Nien khoa
                $table->string('acedemic_term_name')->nullable(TRUE)->default(NULL)->comment('Lưu ten cua nien khoa'); // Nien khoa
                $table->bigInteger('marjors_id')->nullable(TRUE)->default(NULL)->comment('Lưu id cua nganh hoc'); // Nganh hoc
                $table->string('marjors_name')->nullable(TRUE)->default(NULL)->comment('Lưu ten cua nganh hoc'); // Nganh hoc
                $table->text('semester')->nullable(TRUE)->default(NULL)->comment('Lưu ten cua nganh hoc'); // Hoc ky
                $table->bigInteger('created_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người tạo');
                $table->bigInteger('updated_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người sừa');
                $table->bigInteger('deleted_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người xóa');                
                $table->timestamps();
                $table->softDeletes();                
            });
        }
    }
};
