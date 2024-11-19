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
        Schema::create('taggings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_satwa')->constrained('satwas')->onDelete('cascade');
            $table->string('jenis_tagging',50)->nullable();
            $table->string('kode_tagging',255)->nullable();
            $table->string('alasan_belum_tagging',255)->nullable();
            $table->string('ba_tagging',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taggings');
    }
};
