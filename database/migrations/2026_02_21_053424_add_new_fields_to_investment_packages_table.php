<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('investment_packages', function (Blueprint $table) {
            // Add new columns only if they don't exist
            if (!Schema::hasColumn('investment_packages', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('investment_packages', 'price')) {
                $table->decimal('price', 15, 2)->nullable();
            }
            if (!Schema::hasColumn('investment_packages', 'status')) {
                $table->string('status')->default('draft');
            }
            if (!Schema::hasColumn('investment_packages', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('investment_packages', 'slug')) {
                $table->string('slug')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('investment_packages', function (Blueprint $table) {
            $table->dropColumn(['description', 'price', 'status', 'image', 'slug']);
        });
    }
};
