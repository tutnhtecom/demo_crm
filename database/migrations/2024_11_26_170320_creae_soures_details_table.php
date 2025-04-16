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
        if(!Schema::hasTable('sources_details')){
            Schema::create('sources_details', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('sources_id')->unsigned()->nullable()->default(NULL)->comment('Lưu id người bang DVLK');
                $table->bigInteger('sources_rate_id')->unsigned()->nullable()->default(NULL)->comment('Lưu id định mức, quan hệ với bảng sources_details');
                $table->date('sources_date')->nullable(TRUE)->default(NULL)->comment('Lưu ngày tháng năm của chỉ iêu');
                $table->integer('quantity')->nullable(TRUE)->default(0)->comment('Lưu số lượng thí sinh');
                $table->foreign('sources_id')->references('id')->on('sources')->onDelete('cascade');
                $table->foreign('sources_rate_id')->references('id')->on('sources')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(!Schema::hasTable('sources_details')){
            Schema::create('sources_details', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('sources_id')->nullable()->default(NULL)->comment('Lưu id người bang sources');
                $table->bigInteger('sources_rate_id')->nullable()->default(NULL)->comment('Lưu id định mức, quan hệ với bảng sources_rate');
                $table->date('sources_date')->nullable(FALSE)->comment('Lưu ngày tháng năm của chỉ iêu');
                $table->integer('quantity')->nullable(FALSE)->comment('Lưu số lượng thí sinh');
                $table->foreign('sources_id')->references('id')->on('sources')->onDelete('cascade');
                $table->foreign('sources_rate_id')->references('id')->on('sources')->onDelete('cascade');
            });
        }
    }
};
