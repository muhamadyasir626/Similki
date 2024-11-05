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
        Schema::create('lembaga_konservasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_Lk')->constrained('list_lks')->onDelete('cascade');
            $table->string('name');
            $table->string('alamat');
            $table->string('slug')->unique();
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan_desa');
            $table->string('kode_pos');
            $table->string('tahun_izin');
            $table->string('np_izin_peroleh');
            $table->string('link_sk');
            $table->string('legalitas_perizinan');
            $table->string('nomor_tanggal_surat');
            $table->string('bentuk_lk');
            $table->string('pengelola');
            $table->string('nama_pimpinan');
            $table->string('izin_perolehan');
            $table->string('tahun_akred');
            $table->string('nilai_akred');
            $table->string('pks_dengan_lk_lainnya')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembaga__konservasis');
    }
};
