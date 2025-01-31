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
        Schema::create('satwa_perolehans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lk')->nullable()->constrained('lembaga_konservasis')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('asal_lk')->nullable()->constrained('lembaga_konservasis')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_spesies')->nullable()->constrained('list_species')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('jumlah_jantan');
            $table->integer('jumlah_betina');
            $table->integer('jumlah_unknown');
            $table->string('asal_satwa')->index();
            $table->boolean('status_perlindungan');
            $table->foreignId('id_cara_perolehan')->constrained('list_cara_satwa_perolehans')->onDelete('cascade')->onUpdate('cascade');
            
            $table->string('doc_surat_permohonan')->nullable();
            $table->string('path_surat_permohonan')->nullable();

            $table->string('doc_salinan_keputusan_pengadilan')->nullable();
            $table->string('path_salinan_keputusan_pengadilan')->nullable();

            $table->string('doc_berita_acara_pemeriksaan_sarana')->nullable();
            $table->string('path_berita_acara_pemeriksaan_sarana')->nullable();

            $table->string('doc_berita_acara_pemeriksaan_satwa')->nullable();
            $table->string('path_berita_acara_pemeriksaan_satwa')->nullable();

            $table->string('doc_surat_keterangan_kesehatan_satwa')->nullable();
            $table->string('path_surat_keterangan_kesehatan_satwa')->nullable();

            $table->string('doc_keterangan_asal_usul_silsilah_satwa')->nullable();
            $table->string('path_keterangan_asal_usul_silsilah_satwa')->nullable();

            $table->string('doc_surat_keterangan_menerima_hibah')->nullable();
            $table->string('path_surat_keterangan_menerima_hibah')->nullable();

            $table->string('doc_surat_keterangan_memberi_hibah')->nullable();
            $table->string('path_surat_keterangan_memberi_hibah')->nullable();

            $table->string('doc_dokumen_kerja_sama')->nullable();
            $table->string('path_dokumen_kerja_sama')->nullable();

            $table->string('doc_pnbp')->nullable();
            $table->string('path_pnbp')->nullable();

            $table->string('doc_rekomendasi_kepala_b_bksda_asal_satwa')->nullable();
            $table->string('path_rekomendasi_kepala_b_bksda_asal_satwa')->nullable();

            $table->string('doc_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima')->nullable();
            $table->string('path_rekomendasi_kepala_b_bksda_domisili_lk_pemohon_penerima')->nullable();

            $table->string('doc_rekomendasi_scientific_authority_appendix_i_cites')->nullable();
            $table->string('path_rekomendasi_scientific_authority_appendix_i_cites')->nullable();

            $table->string('doc_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa')->nullable();
            $table->string('path_rekomendasi_kepala_b_bksda_domisili_lk_asal_satwa')->nullable();
            
            $table->json('dokumen_lainnya')->nullable();
            
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satwa_perolehans');
    }
};
