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
          Schema::create('leads_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->nullable(); // bigint(20) unsigned
            $table->string('full_name')->nullable(TRUE)->default(NULL)->comment('Lưu họ tên của Thí sinh, sinh viên');
            $table->string('sources_register_failed')->nullable(TRUE)->default(NULL)->comment('Lưu lại nguôn gốc sai  từ đâu');
            $table->string('code', 150)->nullable(TRUE)->default(NULL)->comment('Lưu mã hồ sơ');
            $table->string('leads_code', 150)->nullable(TRUE)->default(NULL)->comment('Lưu mã hồ sơ');
            $table->string('email', 150)->nullable(FALSE)->comment('Lưu email của người quản trị và sử dụng để đăng nhập hệ thống, không được phép trùng');
            $table->string('phone')->nullable(TRUE)->comment('Lưu số điện thoại của Thí sinh, sinh viên');
            $table->string('home_phone')->nullable(TRUE)->comment('Lưu số điện thoại nhà riêng của Thí sinh, sinh viên');
            $table->text('avatar')->nullable(TRUE)->comment('Lưu đường dẫn ảnh của Thí sinh, sinh viên');
            $table->date('date_of_birth')->nullable(TRUE)->comment('Lưu email của người quản trị và sử dụng để đăng nhập hệ thống, không được phép trùng');
            $table->tinyInteger('gender')->nullable(TRUE)->comment('Lưu giới tính của Thí sinh, sinh viên: 0: nữ, 1: nam, 2: khác');
            $table->tinyInteger('steps')->nullable(TRUE)->comment('Lưu giới tính của Thí sinh, sinh viên: 0: nữ, 1: nam, 2: khác');
            $table->tinyInteger('d_email_status')->nullable(TRUE)->comment('Lưu giới tính của Thí sinh, sinh viên: 0: nữ, 1: nam, 2: khác');
            $table->string('identification_card')->nullable(TRUE)->comment('Lưu số CCCD của Thí sinh, sinh viên');
            $table->date('date_identification_card')->nullable(TRUE)->comment('Lưu ngày cấp của CCCD');
            $table->string('place_identification_card')->nullable(TRUE)->comment('Nơi cấp CCCD của Thí sinh, sinh viên');
            $table->string('place_of_birth')->nullable(TRUE)->comment('Lưu nơi sinh của Thí sinh, sinh viên');
            $table->string('place_of_wrk_lrn')->nullable(TRUE)->comment('Lưu nơi làm việc / học tập của Thí sinh, sinh viên');
            //Khóa quan hệ
            $table->bigInteger('sources_id')->unsigned()->nullable()->default(NULL)->comment('Lưu id của nguồn tiếp cận chương trình, là khóa ngoại quan hệ với bảng sources');
            $table->bigInteger('marjors_id')->unsigned()->nullable()->default(NULL)->comment('Lưu id của ngành học, là khóa ngoại quan hệ với bảng majors');
            $table->string('nations_name')->nullable()->default(NULL)->comment('Lưu id của quốc gia');
            $table->string('ethnics_name')->nullable()->default(NULL)->comment('Lưu id của dân tộc');
            $table->text('extended_fields')->nullable()->default(NULL)->comment('Lưu id của dân tộc');
            // Ngày tham gia vào đoàn thanh niên
            $table->date('date_of_join_youth_union')->nullable()->default(NULL)->comment('Lưu ngày kết nạp đoàn thanh niên');
            // Ngày tham gia vào đoàn thanh niên
            $table->date('date_of_join_communist_party')->nullable()->default(NULL)->comment('Lưu ngày kết nạp đảng');
            // Tên cơ quan làm việc
            $table->string('company_name')->nullable()->default(NULL)->comment('Lưu tên công ty đang làm việc');
            $table->string('company_address')->nullable()->default(NULL)->comment('Lưu địa chỉ công ty đang làm việc');
            $table->bigInteger('lst_status_id')->unsigned()->nullable()->default(0)->comment('Lưu  id trạng thái, là khóa ngoại quan hệ với bảng status');
            $table->bigInteger('tags_id')->unsigned()->nullable()->default(NULL)->comment('Lưu id thẻ, sử dụng để gắn tìm kiếm');
            $table->bigInteger('assignments_id')->unsigned()->nullable()->default(NULL)->comment('Lưu id thẻ, sử dụng để gắn tìm kiếm');
            $table->tinyInteger('active_student')->unsigned()->nullable()->default(NULL)->comment('Lưu id thẻ, sử dụng để gắn tìm kiếm');

            $table->bigInteger('created_by')->unsigned()->nullable()->default(NULL)->comment('Lưu id người tạo mới');
            $table->bigInteger('updated_by')->unsigned()->nullable()->default(NULL)->comment('Lưu id người cập nhật');
            $table->bigInteger('deleted_by')->unsigned()->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');
            // Trình độ văn hóa - Trình độ chuyên môn - Phat sinh ra bảng mới degree_informationsh                     
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // đánh index
            $table->index('email');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads_histories');
    }
};
