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
            $table->string('nama',255);
            $table->string('slug',255)->unique();
            $table->foreignId('id_upt')->constrained('list_upts')->onDelete('cascade');
            $table->text('alamat');
            $table->string('kode_pos',5);
            $table->string('provinsi');
            $table->string('kota_kab');
            $table->string('kecamatan');
            $table->string('kelurahan_desa');
            $table->string('tahun_izin');
            $table->text('link_sk');
            $table->text('legalitas_perizinan');
            $table->string('nomor_tanggal_surat');
            $table->string('bentuk_lk');
            $table->string('pengelola');
            $table->string('nama_pimpinan');
            $table->text('izin_perolehan_tsl');
            $table->string('tahun_akred');
            $table->string('nilai_akred');
            $table->text('pks_dengan_lk_lainnya')->nullable();
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