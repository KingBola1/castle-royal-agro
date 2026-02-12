<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            // Check if 'image' exists. If not, add it.
            if (!Schema::hasColumn('packages', 'image')) {
                // We make it nullable so the site doesn't crash if an image is missing
                $table->string('image')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (Schema::hasColumn('packages', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
