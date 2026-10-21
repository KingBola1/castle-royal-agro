<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('investment_packages', function (Blueprint $table) {
            // Make old columns nullable so they don't block new inserts
            if (Schema::hasColumn('investment_packages', 'amount')) {
                $table->decimal('amount', 15, 2)->nullable()->change();
            }
            if (Schema::hasColumn('investment_packages', 'acres')) {
                // FIXED: Changed integer() back to decimal() to allow 0.5 values
                $table->decimal('acres', 8, 2)->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('investment_packages', function (Blueprint $table) {
            // Reverse the change if needed
            if (Schema::hasColumn('investment_packages', 'amount')) {
                $table->decimal('amount', 15, 2)->nullable(false)->change();
            }
            if (Schema::hasColumn('investment_packages', 'acres')) {
                $table->decimal('acres', 8, 2)->nullable(false)->change();
            }
        });
    }
};