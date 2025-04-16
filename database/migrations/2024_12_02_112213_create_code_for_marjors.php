<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{    
    public function up(): void
    {
        if(Schema::hasTable('marjors') && !Schema::hasColumn('marjors', 'code')){
            Schema::table('marjors', function (Blueprint $table) {
                $table->string('code')->nullable(FALSE)->after('name')->comment('Lưu code của chuyên ngành');
            });
        }
    }

    public function down(): void
    {
        if(Schema::hasTable('marjors') && !Schema::hasColumn('marjors', 'code')){
            Schema::table('marjors', function (Blueprint $table) {
                $table->string('code')->nullable(FALSE)->after('name')->comment('Lưu code của chuyên ngành');
            });
        }
    }
};
