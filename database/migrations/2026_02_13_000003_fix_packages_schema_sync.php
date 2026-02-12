<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            // 1. Fix Image: Add it if missing
            if (!Schema::hasColumn('packages', 'image')) {
                $table->string('image')->nullable()->after('status');
            }

            // 2. Fix Price: Add it if missing
            if (!Schema::hasColumn('packages', 'price')) {
                $table->decimal('price', 15, 2)->default(0.00)->after('description');
            }

            // 3. Fix Description: Make it nullable to prevent "Not Null Violation" crashes
            // We use 'change()' to modify the existing column.
            $table->text('description')->nullable()->change();
        });
    }

    public function down(): void
    {
        // No down method needed for safety (we don't want to revert these fixes)
    }
};
