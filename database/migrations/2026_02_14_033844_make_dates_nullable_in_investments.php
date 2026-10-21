<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Using raw SQL for Postgres to drop NOT NULL constraint only if the columns exist
        if (DB::getDriverName() === 'pgsql') {
            if (Schema::hasColumn('investments', 'start_date')) {
                DB::statement('ALTER TABLE investments ALTER COLUMN start_date DROP NOT NULL');
            }

            if (Schema::hasColumn('investments', 'end_date')) {
                DB::statement('ALTER TABLE investments ALTER COLUMN end_date DROP NOT NULL');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add NOT NULL constraint only if the columns exist
        if (DB::getDriverName() === 'pgsql') {
            if (Schema::hasColumn('investments', 'start_date')) {
                DB::statement('ALTER TABLE investments ALTER COLUMN start_date SET NOT NULL');
            }

            if (Schema::hasColumn('investments', 'end_date')) {
                DB::statement('ALTER TABLE investments ALTER COLUMN end_date SET NOT NULL');
            }
        }
    }
};