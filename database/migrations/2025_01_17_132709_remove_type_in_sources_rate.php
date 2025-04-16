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
        if(Schema::hasTable('sources_rate') && Schema::hasColumn('sources_rate', 'payment_manager_type')) {
            // Schema::dropIfExists('payment_manager_type');
            Schema::dropColumns('sources_rate', 'payment_manager_type');
        }
        if(Schema::hasTable('sources_rate') && Schema::hasColumn('sources_rate', 'payment_type')) {
            // Schema::dropIfExists('payment_type');
            Schema::dropColumns('sources_rate', 'payment_type');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('sources_rate') && Schema::hasColumn('sources_rate', 'payment_manager_type')) {
            // Schema::dropIfExists('payment_manager_type');
            Schema::dropColumns('sources_rate', 'payment_manager_type');
        }
        if(Schema::hasTable('sources_rate') && Schema::hasColumn('sources_rate', 'payment_type')) {
            // Schema::dropIfExists('payment_type');
            Schema::dropColumns('sources_rate', 'payment_type');
        }
    }
};
