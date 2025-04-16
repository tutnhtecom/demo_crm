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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();    
            $table->bigInteger('types_id')->unsigned()->nullable(false)->comment('Lưu id của loại mẫu email');
            $table->string('title', 200)->nullable(false)->comment('Lưu tiêu đề của mẫu mail');
            $table->text('content')->nullable(false)->comment('Lưu nội dung template');
            $table->text('file_name')->nullable()->default(NULL)->comment('Lưu nội dung template');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
            $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
            $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');

            $table->foreign('types_id')->references('id')->on('email_template_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
