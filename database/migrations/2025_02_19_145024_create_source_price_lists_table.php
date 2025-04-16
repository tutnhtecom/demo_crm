<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        if(!Schema::hasTable('source_price_lists')) {
            Schema::create('source_price_lists', function (Blueprint $table) {
                $table->id();
                // Sinh viên
                $table->bigInteger('students_id')->nullable(TRUE)->default(NULL)->comment('Luu id cua sinh vien'); // sinh vien
                $table->string('students_name')->nullable(TRUE)->default(NULL)->comment('Luu ten cua sinh vien'); // sinh vien
                $table->string('students_code')->nullable(TRUE)->default(NULL)->comment('Luu mã cua sinh vien'); // sinh vien
                $table->string('students_phone')->nullable(TRUE)->default(NULL)->comment('Luu số điện thoại cua sinh vien'); // sinh vien
                $table->string('students_email')->nullable(TRUE)->default(NULL)->comment('Luu ten cua sinh vien'); // sinh vien
                // KHóa học
                $table->bigInteger('acedemic_term_id')->nullable(TRUE)->default(NULL)->comment('Lưu id cua nien khoa'); // Nien khoa
                $table->string('acedemic_term_name')->nullable(TRUE)->default(NULL)->comment('Lưu ten cua nien khoa'); // Nien khoa
                // Ngành học
                $table->bigInteger('marjors_id')->nullable(TRUE)->default(NULL)->comment('Lưu id cua nganh hoc'); // Nganh hoc
                $table->string('marjors_name')->nullable(TRUE)->default(NULL)->comment('Lưu ten cua nganh hoc'); // Nganh hoc   
                // Đơn vị liên kết             
                $table->bigInteger('sources_id')->nullable(TRUE)->default(NULL)->comment('Lưu id của đối tác liên kết'); // DVLK
                $table->string('sources_name')->nullable(TRUE)->default(NULL)->comment('Luu ten của DVLK');// DVLK
                $table->string('sources_code')->nullable(TRUE)->default(NULL)->comment('Luu mã của ĐVLK');// DVLK
                // Học kỳ
                $table->bigInteger('semesters_id')->nullable(TRUE)->default(NULL)->comment('Lưu id của học kỳ'); // DVLK
                $table->string('semesters_name')->nullable(TRUE)->default(NULL)->comment('Luu ten của học kỳ');// DVLK
                $table->integer('semesters_year')->nullable(TRUE)->default(NULL)->comment('Luu năm của học kỳ');// DVLK
                // Học phí               
                $table->double('price')->nullable(TRUE)->default(0)->comment('Lưu tiền học phí sinh viên đóng'); // Hoc ky
                $table->double('old_debt')->nullable(TRUE)->default(0)->comment('Lưu nợ cũ của sinh viên'); // Hoc ky
                $table->text('note')->nullable(TRUE)->default(NULL)->comment('Luu ghi chú');// DVLK


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
        Schema::dropIfExists('source_price_lists');
    }
};
