<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('lembaga_konservasis', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('id_upt')->constrained('list_upts')->onDelete('cascade')->onUpdate('cascade'); // Foreign Key id_upt
            $table->string('nama');
            $table->index('nama');
            $table->string('slug')->unique();
            $table->string('bentuk_lk');
            $table->string('nib');
            $table->index('nib');
            $table->string('npwp');
            $table->index('npwp');
            $table->string('email')->unique();
            $table->string('kode_pos',5);
            $table->string('provinsi');
            $table->string('kota_kab');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('alamat');
            $table->string('nama_direktur');
            $table->index('nama_direktur');
            $table->string('no_telp')->unique();
            // $table->integer('jumlah_pegawai_laki_laki');
            // $table->integer('jumlah_pegawai_perempuan');
            $table->integer('jumlah_tenaga_kerja');
            $table->string('jumlah_investasi');
            $table->decimal('luas_wilayah', 10, 2); 
            $table->string('doc_site_plan');
            $table->string('path_site_plan');
            $table->string('doc_persetujuan_lingkungan');
            $table->string('path_persetujuan_lingkungan');
            $table->string('doc_draft_rkp');
            $table->string('path_draft_rkp');
            $table->string('doc_surat_permohonan');
            $table->string('path_surat_permohonan');
            $table->boolean('status')->default(0);
            $table->timestamps(); 
        });
    }

    /**
     * Rollback migrasi, menghapus tabel.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lembaga_konservasis');
    }

};