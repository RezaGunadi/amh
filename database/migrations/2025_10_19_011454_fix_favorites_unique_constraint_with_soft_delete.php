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
        // Untuk MySQL dengan soft delete, kita tidak menggunakan unique constraint
        // karena akan konflik dengan data yang sudah di-soft-delete
        // Sebagai gantinya, kita akan menangani duplikasi di level aplikasi
        
        // Menambahkan index untuk performa query
        Schema::table('favorites', function (Blueprint $table) {
            $table->index(['user_id', 'food_id'], 'favorites_user_food_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropIndex('favorites_user_food_index');
        });
    }
};
