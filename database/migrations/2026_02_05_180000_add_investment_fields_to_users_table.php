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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('total_invested', 15, 2)->default(0)->after('password');
            $table->decimal('active_acres', 10, 2)->default(0)->after('total_invested');
            $table->decimal('projected_roi', 10, 2)->default(0)->after('active_acres');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['total_invested', 'active_acres', 'projected_roi']);
        });
    }
};
