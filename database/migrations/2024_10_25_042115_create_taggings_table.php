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
            $table->string('jenis_tagging',50)->nullable();
<<<<<<< Updated upstream
            $table->string('kode_tagging',255)->nullable();
            $table->string('alasan_belum_tagging',255)->nullable();
            $table->string('ba_tagging',255)->nullable();
            $table->date('tanggal_tagging',255)->nullable();
=======
>>>>>>> Stashed changes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagging');
    }
};
