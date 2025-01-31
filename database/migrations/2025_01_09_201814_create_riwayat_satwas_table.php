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
        Schema::create('riwayat_satwas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_satwa_koleksi_individu')->constrained('satwa_koleksi_individus')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->foreignId('id_satwa_koleksi_kelompok')->constrained('satwa_koleksi_kelompoks')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_satwa_titipan')->constrained('satwa_titipans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_satwa_perolehan')->constrained('satwa_perolehans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('action',['create','update', 'delete']);
            $table->string('keterangan'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_satwa');
    }
};
