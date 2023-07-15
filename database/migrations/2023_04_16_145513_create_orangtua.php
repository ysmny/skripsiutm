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
        Schema::create('orangtua', function (Blueprint $table) {
            $table->increments('id_orangtua');
            $table->string('nama_orangtua');
            $table->string('alamat');
            $table->string('no_hp_orangtua');
            $table->string('password_orangtua');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orangtua');
    }
};
