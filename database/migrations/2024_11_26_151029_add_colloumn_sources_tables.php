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
        if(Schema::hasTable('sources')){            
            if(!Schema::hasColumn('sources','sources_types')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->string('sources_types')->nullable()->default(null)->after('id')->comment('Lưu phân loại đối tác');
                });

            }
            if(!Schema::hasColumn('sources','code')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->string('code')->nullable()->default(null)->after('name')->comment('Lưu mã đối tác');
                });
            }
            if(!Schema::hasColumn('sources','location_name')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->string('location_name')->nullable()->default(null)->after('code')->comment('Lưu tên địa phương');
                });
            }
            if(!Schema::hasColumn('sources','sources_manager_name')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->string('sources_manager_name')->nullable()->default(null)->after('code')->comment('Lưu tên lãnh đạo của đối tác');
                });
            }
            if(!Schema::hasColumn('sources','sources_employees_name')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->text('sources_employees_name')->nullable()->default(null)->after('code')->comment('Lưu tên nhân viên của đối tác');
                });
            }
            if(!Schema::hasColumn('sources','signed_document')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->string('signed_document')->nullable()->default(null)->after('code')->comment('Lưu tên văn bảng ký kết');
                });
            }
            if(!Schema::hasColumn('sources','signed_content')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->text('signed_content')->nullable()->default(null)->after('code')->comment('Lưu nội dung hợp tác');
                });
            }

            if(!Schema::hasColumn('sources','from_date')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->date('signed_from_date')->nullable()->default(null)->after('code')->comment('Lưu thời gian bắt đầu hợp tác');
                });
            }
            if(!Schema::hasColumn('sources','to_date')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->date('signed_to_date')->nullable()->default(null)->after('code')->comment('Lưu thời gian bắt đầu hợp tác');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('sources')){            
            if(!Schema::hasColumn('sources','sources_types')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->string('sources_types')->nullable()->default(null)->after('id')->comment('Lưu phân loại đối tác');
                });

            }
            if(!Schema::hasColumn('sources','code')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->string('code')->nullable()->default(null)->after('name')->comment('Lưu mã đối tác');
                });
            }
            if(!Schema::hasColumn('sources','location_name')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->string('location_name')->nullable()->default(null)->after('code')->comment('Lưu tên địa phương');
                });
            }
            if(!Schema::hasColumn('sources','sources_manager_name')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->string('sources_manager_name')->nullable()->default(null)->after('code')->comment('Lưu tên lãnh đạo của đối tác');
                });
            }
            if(!Schema::hasColumn('sources','sources_employees_name')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->text('sources_employees_name')->nullable()->default(null)->after('code')->comment('Lưu tên nhân viên của đối tác');
                });
            }
            if(!Schema::hasColumn('sources','signed_document')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->string('signed_document')->nullable()->default(null)->after('code')->comment('Lưu tên văn bảng ký kết');
                });
            }
            if(!Schema::hasColumn('sources','signed_content')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->text('signed_content')->nullable()->default(null)->after('code')->comment('Lưu nội dung hợp tác');
                });
            }

            if(!Schema::hasColumn('sources','from_date')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->date('signed_from_date')->nullable()->default(null)->after('code')->comment('Lưu thời gian bắt đầu hợp tác');
                });
            }
            if(!Schema::hasColumn('sources','to_date')) {
                Schema::table('sources', function (Blueprint $table) {                    
                    $table->date('signed_to_date')->nullable()->default(null)->after('code')->comment('Lưu thời gian bắt đầu hợp tác');
                });
            }            
        }
    }
};
