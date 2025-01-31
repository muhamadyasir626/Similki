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
        Schema::create('satwa_koleksi_individus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lk')->constrained('lembaga_konservasis')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_spesies')->constrained('list_species')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('kondisi_satwa');
            // $table->string('status_hukum'); //koleksi(0) , titipan(1), perolehan(2)
            $table->string('status_perlindungan_satwa');
            $table->string('nama_panggilan');
            $table->index('nama_panggilan');
            $table->foreignId('bentuk_tagging')->constrained('taggings')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('kode_tagging', 100);
            $table->index('kode_tagging');
            $table->boolean('jenis_kelamin'); // jantan(1) or betina(0)
            $table->integer('umur');
            $table->date('tanggal_lahir')->nullable();
            $table->string('asal_usul');
            $table->foreignId('cara_perolehan_koleksi')->nullable()->constrained('list_cara_perolehan_koleksis')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('doc_asal_usul');
            $table->text('path_asal_usul'); 
            $table->string('doc_bap_kelahiran');
            $table->text('path_bap_kelahiran'); 
            $table->boolean('asal_satwa'); // Indonesia(1) or asing(0)
            $table->string('sk_perolehan_koleksi_dirjen')->nullable();
            $table->string('sk_perolehan_koleksi_kepala_balai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satwa_koleksi_individu');
    }
};
