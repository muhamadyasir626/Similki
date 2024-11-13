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
        Schema::create('monitoring_investasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lk')->constrained('lembaga_konservasis')->onDelete('cascade');
            $table->decimal('jumlah_karyawan_laki');
            $table->decimal('jumlah_karyawan_perempuan');
            $table->decimal('jumlah_dokter_hewan');
            $table->decimal('jumlah_lahan_konservasi');
            $table->decimal('jumlah_investasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_investasis');
    }
};
