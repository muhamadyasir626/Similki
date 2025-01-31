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
        Schema::create('riwayat_lks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->foreignId('id_lk')->nullable()->constrained('lembaga_konservasis')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->foreignId('id_satwa_perolehan')->nullable()->constrained('satwa_koleksi_perolehan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nama_lk')->index();
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
        Schema::dropIfExists('riwayat_lks');
    }
};
