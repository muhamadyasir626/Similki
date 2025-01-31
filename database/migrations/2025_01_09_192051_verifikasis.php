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
        Schema::create('verifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_lk')->nullable()->constrained('lembaga_konservasis')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_satwa_koleksi_individu')->nullable()->constrained('satwa_koleksi_individus')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_satwa_perolehan')->nullable()->constrained('satwa_perolehans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_barang_konservasi')->nullable()->constrained('barang_konservasis')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('status',['rejected','in progress','update','Approved']);
            $table->string('perbaikan')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasis');
    }
};
