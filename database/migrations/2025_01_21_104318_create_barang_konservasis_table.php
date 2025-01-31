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
        Schema::create('barang_konservasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lk')->constrained('lembaga_konservasis')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama')->index();
            $table->foreignId('jenis_barang')->constrained('list_jenis_barangs')->onDelete('cascade')->onUpdate('cascade');
            $table ->integer('jumlah');
            $table->string('negara_asal')->index();
            $table->string('pelabuhan_masuk')->index();
            $table->decimal('perkiraan_nilai',20,2);
            $table->string('doc_surat_permohonan');
            $table->string('path_surat_permohonan');
            $table->string('doc_surat_pernyataan');
            $table->string('path_surat_pernyataan');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_konservasis');
    }
};
