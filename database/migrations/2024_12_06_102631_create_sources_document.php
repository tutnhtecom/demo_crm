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
        Schema::create('sources_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sources_id')->unsigned()->nullable(false)->comment('Lưu id của đối tác liên kết');
            $table->string('signed_document')->nullable(false)->comment('Lưu văn bản ký kết');
            $table->string('signed_content')->nullable(false)->comment('Lưu nội dung hợp tác');
            $table->date('signed_from_date')->nullable(false)->comment('Lưu thời gian bắt đầu hợp tác');
            $table->date('signed_to_date')->nullable(false)->comment('Lưu thời gian bắt đầu hợp tác');
            $table->bigInteger('created_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người tạo');
            $table->bigInteger('updated_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người sừa');
            $table->bigInteger('deleted_by')->nullable(TRUE)->default(NULL)->comment('Lưu id của người xóa');                
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sources_id')->references('id')->on('sources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sources_documents');
    }
};
