<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if id column already exists
        if (!Schema::hasColumn('password_resets', 'id')) {
            // Use raw SQL to add id column as primary key
            // This is safer for existing tables
            DB::statement('ALTER TABLE `password_resets` ADD COLUMN `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop primary key first, then drop id column
        DB::statement('ALTER TABLE `password_resets` DROP PRIMARY KEY');
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
};
