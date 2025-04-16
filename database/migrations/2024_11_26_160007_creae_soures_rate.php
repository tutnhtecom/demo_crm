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
        if(!Schema::hasTable('sources_rate')){
            Schema::create('sources_rate', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('sources_id')->unsigned()->nullable(FALSE)->default(NULL)->comment('Lưu id người bang sources');
                $table->string('expense_name')->nullable(FALSE)->comment('Lưu tên khoảng chi');
                $table->integer('payment_condition')->nullable(TRUE)->default(NULL)->comment('Lưu điều kiện thanh toán');
                $table->tinyText('math_sign')->nullable(TRUE)->default(NULL)->comment('Lưu dấu toán học: < > =');  
                $table->double('payment_rate')->nullable(TRUE)->default(NULL)->comment('Lưu định mức thanh toán');                
                $table->string('payment_note')->nullable(TRUE)->default(NULL)->comment('Lưu lại thời gian thực hiện thanh toán');
                $table->timestamps();
                $table->softDeletes();
                $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
                $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
                $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');                                
                $table->foreign('sources_id')->references('id')->on('sources')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(!Schema::hasTable('sources_rate')){
            Schema::create('sources_rate', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('sources_id')->unsigned()->nullable()->default(NULL)->comment('Lưu id người bang sources');
                $table->string('expense_name')->nullable(FALSE)->comment('Lưu tên khoảng chi');
                $table->double('payment_condition')->nullable(FALSE)->comment('Lưu điều kiện thanh toán');
                $table->double('payment_rate')->nullable(FALSE)->comment('Lưu định mức thanh toán');                
                $table->string('payment_note')->nullable(FALSE)->comment('Lưu lại thời gian thực hiện thanh toán');
                $table->timestamps();
                $table->softDeletes();
                $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
                $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
                $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');                
                
                $table->foreign('sources_id')->references('id')->on('sources')->onDelete('cascade');
            });
        }
    }
};
