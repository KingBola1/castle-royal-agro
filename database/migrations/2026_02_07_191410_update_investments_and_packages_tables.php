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
        Schema::table('investments', function (Blueprint $table) {
            $table->string('package_name')->nullable()->after('user_id');
        });

        Schema::table('investment_packages', function (Blueprint $table) {
            $table->decimal('acres', 8, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->dropColumn('package_name');
        });

        Schema::table('investment_packages', function (Blueprint $table) {
            $table->decimal('acres', 8, 2)->nullable(false)->change();
        });
    }
};
