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
        Schema::create('menu_makanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_makanan');
            $table->string('kategori');
            $table->text('deskripsi_menu')->nullable();
            $table->text('komposisi')->nullable();
            $table->string('foto')->nullable();
            $table->integer('berat_g')->nullable();
            $table->decimal('energi_kkal', 10, 2)->nullable();
            $table->decimal('protein_gram', 10, 2)->nullable();
            $table->decimal('lemak_gram', 10, 2)->nullable();
            $table->decimal('karbohidrat_gram', 10, 2)->nullable();
            $table->decimal('gula_gram', 10, 2)->nullable();
            $table->decimal('natrium_mg', 10, 2)->nullable();
            $table->decimal('serat_gram', 10, 2)->nullable();
            $table->decimal('zat_besi_mg', 10, 2)->nullable();
            $table->decimal('kalsium_mg', 10, 2)->nullable();
            $table->integer('skor_zat_gizi')->nullable();
            $table->integer('protein_persen')->nullable();
            $table->integer('lemak_persen')->nullable();
            $table->integer('gula_persen')->nullable();
            $table->integer('garam_persen')->nullable();
            $table->integer('serat_persen')->nullable();
            $table->integer('zat_besi_persen')->nullable();
            $table->integer('kalsium_persen')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_makanan');
    }
};
