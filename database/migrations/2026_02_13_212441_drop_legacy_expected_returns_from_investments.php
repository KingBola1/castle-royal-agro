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
        \Illuminate\Support\Facades\Schema::table('investments', function (\Illuminate\Database\Schema\Blueprint $table) {
            if (\Illuminate\Support\Facades\Schema::hasColumn('investments', 'expected_returns')) {
                $table->dropColumn('expected_returns');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\Schema::table('investments', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->decimal('expected_returns', 15, 2)->nullable();
        });
    }
};
