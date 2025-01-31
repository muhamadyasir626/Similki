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
        Schema::create('satwa', function (Blueprint $table) {
            $table->id(); 
        //{ $table->foreignId('id_lk')->constrained('lembaga_konservasis')->onDelete('cascade');
            // $table->string('jenis_koleksi', 50);//satwa hidup/awetan
            // $table->string('asal_satwa', 50);
            // $table->string('no_sats_ln')->nullable();
            // $table->foreignId('id_spesies')->constrained('list_species')->onDelete('cascade');
            // $table->boolean('status_perlindungan')->nullable(); // dilindugi (1) || tidak dilindugi (0)
            // $table->boolean('pengambilan_satwa')->nullable(); //alam(1) || bukan alam (0)
            // $table->string('sk_kepala')->nullable();
            // $table->string('sk_ksdae')->nullable();
            // $table->string('sk_menteri')->nullable();
            // $table->date('tanggal_kelahiran');
            // $table->date('tanggal_kematian')->nullable();
            // $table->boolean('perilaku_satwa'); // individu (1) || berkelompok (0)
            // $table->boolean('jenis_kelamin')->nullable(); // jantan (1) || betina (0)
            // $table->string('status_satwa', 50); // satwa {titipan, koleksi}, breeding loan, rehabilitasi
            // $table->string('no_izin_peroleh',50)->nullable();
            // $table->string('no_ba_titipan')->nullable();
            // $table->string('no_ba_kelahiran')->nullable();
            // $table->string('no_ba_kematian')->nullable();
            // $table->string('nama_panggilan', 50)->nullable();
            // $table->date('validasi_tanggal')->nullable();
            // $table->date('tanggal_titipan')->nullable();
            // $table->text('keterangan')->nullable();
            // $table->integer('Verifikasi')->default(0);
        // }

            $table->id(); 
            $table->foreignId('id_lk')->constrained('lembaga_konservasis')->onDelete('cascade');
            $table->foreignId('id_spesies')->constrained('list_species')->onDelete('cascade');
            $table->boolean('status_hukum'); // koleksi(0) || titipan(1)
            $table->enum('kondisi_satwa',[0,1,2]); // hidup(1) || mati(0) || awetan(2)
            $table->boolean('kategori_satwa'); // kelompok(0) || indinvidu(1)
            $table->boolean('status_perlindungan'); // tidak dilindungi (0) || dilindungi(1)

            #koleksi 
            $table->String('nama_panggilan')->nullable();
            $table->enum('bentuk_tagging',[0,1,2,3])->nullable(); // chip(0) || eartag(1) || label(2) || ring(3)
            $table->string('kode_tagging')->nullable();
            $table->boolean('jenis_kelamin')->nullable(); // betina(0) || jantan(1)
            $table->integer('umur')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('asal_usul')->nullable(); // silsilah
            $table->enum('perolehan_satwa_koleksi',[0,1,2,3,4,5,6])->nullable(); //{0: penyerahan, 1:hibah, pemberian atau sumbangan, 2: tukar-menukar, 3: peminjaman, 4: pengambilan, 5: pembelian, 6: pengambilan/penangkapan dari alam}
            $table->string('sk_dirjen_perolehan_koleksi')->nullable();
            $table->string('path_sk_dirjen_perolehan_koleksi')->nullable();
            $table->string('sk_kepala_balai_perolehan_koleksi')->nullable();
            $table->string('path_sk_kepala_balai_perolehan_koleksi')->nullable();

            #titipan
            $table->string('no_bap_titipan');
            $table->enum('asal_satwa_titipan',[0,1,2,3,4,5,6,7,8,9,10]);

            /*
            #Master data asal titipan 
            0 penyerahan masyarakat
            1 sitaan
            2 konflik satwa-manusia
            3 repatriasi
            4 rampasan
            5 temuan
            6 tegahan
            7 dampak bencana alam, bencana non alam atau kegiatan manusia
            8 wilayah yang terisolir
            9 LK
            10 penangkaran 
            */

            $table->integer('jumlah_satwa_jantan');
            $table->integer('jumlah_satwa_betina');
            $table->integer('jumlah_unknown');
            $table->string('dokumen_bap_titipan');
            $table->string('path_dokumen_bap_titipan');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satwa');
    }
};
