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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('jenis_kelamin'); //laki-laki (1) || perempuan (0)
            $table->foreignId('id_ayah')->references('id')->on('satwas')->onDelete('set null')->nullable();
            $table->foreignId('id_ibu')->references('id')->on('satwas')->onDelete('set null')->nullable();
            $table->foreignId('id_pasangan')->references('id')->on('satwas')->onDelete('set null')->nullable();
            $table->foreignId('id_anak')->references('id')->on('satwas')->onDelete('set null')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
