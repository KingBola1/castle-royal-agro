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
            $table->string('slug')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->decimal('price', 15, 2)->nullable()->change();
            $table->decimal('roi_percentage', 5, 2)->nullable()->change();
            $table->integer('duration_months')->nullable()->change();
            $table->string('status')->default('draft')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting nullable changes can be tricky if data exists, so we leave it.
    }
};
