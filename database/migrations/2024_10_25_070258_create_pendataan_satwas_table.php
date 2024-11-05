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
        Schema::create('pendataan_satwa', function (Blueprint $table) {
            $table->id('id_pendataan'); // Corrected primary key definition
            $table->string('jenis_koleksi', 50);
            $table->string('asal_satwa', 50);
            $table->string('no_sats_ln')->nullable();
            $table->string('status_perlindungan')->nullable();
            $table->string('pengambilan_satwa', 50);
            $table->string('sk_kepala')->nullable();
            $table->string('sk_ksdae')->nullable();
            $table->string('sk_menteri')->nullable();
            $table->string('perilaku_satwa', 50);
            $table->string('jenis_kelamin_individu', 20);
            $table->string('sudah_tagging', 20);
            $table->foreignId('id_tagging')->constrained('taggings')->onDelete('cascade'); // Correct foreign key
            $table->string('kode_tagging')->nullable();
            $table->string('nama_lokal', 255);
            $table->string('nama_universal', 255);
            $table->string('nama_ilmiah', 255);
            $table->string('nama_panggilan', 50);
            $table->string('class', 25);
            $table->string('genus', 255);
            $table->string('spesies', 255);
            $table->string('sub_spesies', 255)->nullable();
            $table->string('status_satwa', 50);
            $table->decimal('jumlah_male', 10, 2);
            $table->decimal('jumlah_female', 10, 2);
            $table->decimal('jumlah_unsex', 10, 2);
            $table->decimal('jumlah_keseluruhan_gender', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendataan_satwas');
    }
};
