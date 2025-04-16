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
        // Xóa trường trong bảng kpis
        if(Schema::hasTable('kpis') && Schema::hasColumn('kpis', 'status')) {
            Schema::table('kpis', function($table) {
                $table->dropColumn('status');                
            });
        }
        // Tạo bảng kpis status
        if(!Schema::hasTable('kpis_status')) {
            Schema::create('kpis_status', function (Blueprint $table) {
                $table->id();
                $table->tinyInteger('status')->nullable(TRUE)->default(0)->comment('Lưu trạng thái: 0 không lưu, 1: có lưu');
                $table->string('descripts')->nullable()->default("Lưu trạng thái của KPI có lưu sang tháng tiếp theo hay không")->comment('Mô tả');
                $table->timestamps();
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpis_status');
    }
};
