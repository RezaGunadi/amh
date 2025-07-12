<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
           
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('passwords');
            $table->string('role')->nullable();
            $table->longText('image')->nullable();
            $table->longText('sekolah')->nullable();
            $table->longText('alamat')->nullable();
            $table->string('kelas')->nullable();
            $table->string('hp')->nullable();
            $table->string('point')->nullable();
            $table->string('rating')->nullable();
            $table->longText('status')->nullable();
            $table->longText('life_motto')->nullable();
            $table->integer('is_active')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
