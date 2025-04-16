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
        if(!Schema::hasTable('config_voip')) {
            Schema::create('config_voip', function (Blueprint $table) {
                $table->id();
                $table->string('api_key')->nullable(false)->comment('Lưu api key của voip');
                $table->string('api_secret')->nullable(false)->comment('Lưu api_secret của voip');
                $table->string('voip_ip')->nullable(false)->comment('Lưu voip_ip của voip');
                $table->timestamps();
                $table->softDeletes();
                $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
                $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
                $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_voip');
    }
};
