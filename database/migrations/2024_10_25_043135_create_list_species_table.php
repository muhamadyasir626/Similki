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
        Schema::create('list_species', function (Blueprint $table) {
            $table->id('id_spesies');
            $table->string('class',255);
            $table->string('genus',255);
            $table->string('spesies',255);
            $table->string('subspesies',255);
            $table->string('nama_lokal',255);
            $table->string('nama_ilmiah',255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_species');
    }
};
