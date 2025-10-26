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
        Schema::create('user_id_mapping', function (Blueprint $table) {
            $table->string('uuid_id', 36)->primary();
            $table->unsignedBigInteger('bigint_id');
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('bigint_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_id_mapping');
    }
};
