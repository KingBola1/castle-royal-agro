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
        Schema::table('packages', function (Blueprint $table) {
            // Check for missing columns and add them
            if (!Schema::hasColumn('packages', 'price')) {
                $table->decimal('price', 10, 2)->after('description');
            }
            if (!Schema::hasColumn('packages', 'roi_percentage')) {
                $table->decimal('roi_percentage', 5, 2)->after('price');
            }
            if (!Schema::hasColumn('packages', 'duration_months')) {
                $table->integer('duration_months')->after('roi_percentage');
            }
            // Check for legacy column and rename/drop if necessary
            if (Schema::hasColumn('packages', 'price_per_unit')) {
                $table->dropColumn('price_per_unit');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['price', 'roi_percentage', 'duration_months']);
        });
    }
};
