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
        Schema::create('satwas', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('id_lk')->constrained('lembaga_konservasis')->onDelete('cascade');
            $table->string('jenis_koleksi', 50);//satwa hidup/awetan
            $table->string('asal_satwa', 50);
            $table->string('no_sats_ln')->nullable();
            $table->foreignId('id_spesies')->constrained('list_species')->onDelete('cascade');
            $table->boolean('status_perlindungan')->nullable(); // dilindugi (1) || tidak dilindugi (0)
            $table->boolean('pengambilan_satwa')->nullable(); //alam(1) || bukan alam (0)
            $table->string('sk_kepala')->nullable();
            $table->string('sk_ksdae')->nullable();
            $table->string('sk_menteri')->nullable();
            $table->boolean('perilaku_satwa'); // individu (1) || berkelompok (0)
            $table->boolean('jenis_kelamin_individu')->nullable(); // jantan (1) || betina (0)
            $table->string('status_satwa', 50); // satwa {titipan, koleksi}, breeding loan, rehabilitasi
            $table->decimal('jumlah_jantang', 10, 2);
            $table->decimal('jumlah_betina', 10, 2);
            $table->decimal('jumlah_unsex', 10, 2);
            $table->decimal('jumlah_keseluruhan_gender', 10, 2);
            $table->string('no_izin_peroleh',50);
            // $table->foreignId('id_tagging')->constrained('taggings')->onDelete('cascade'); // Correct foreign key
            $table->string('no_ba_titipan')->nullable();
            $table->string('no_ba_kelahiran')->nullable();
            $table->string('no_ba_kematian')->nullable();
            $table->string('nama_panggilan', 50);
            $table->date('validasi_tanggal');
            $table->string('tahun_titipan',4);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendataan_satwas');
    }
};
