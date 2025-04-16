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
        if(Schema::hasTable('semesters') && !Schema::hasColumn('semesters', 'semesters_year')) {
            Schema::table('semesters', function (Blueprint $table) {
                $table->string('semesters_year')->nullable(TRUE)->default(NULL)->after('name')->comment('Lưu năm bắt đầu - năm kế thúc');
            });
        }
    }

    public function down(): void
    {
        if(Schema::hasTable('semesters') && !Schema::hasColumn('semesters', 'semesters_year')) {
            Schema::table('semesters', function (Blueprint $table) {
                $table->string('semesters_year')->nullable(TRUE)->default(NULL)->after('name')->comment('Lưu năm bắt đầu - năm kế thúc');
            });
        }
    }
};
