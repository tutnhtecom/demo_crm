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
        if(Schema::hasTable('kpis') && !Schema::hasColumn('kpis', 'semesters_id')) {
            Schema::table('kpis', function($table) {
                $table->bigInteger('semesters_id')->nullable(TRUE)->default(null)->after('quantity')->comment('Lưu id của học kỳ');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('kpis') && !Schema::hasColumn('kpis', 'semesters_id')) {
            Schema::table('kpis', function($table) {
                $table->bigInteger('semesters_id')->nullable(TRUE)->default(null)->after('quantity')->comment('Lưu id của học kỳ');
            });
        }
    }
};
