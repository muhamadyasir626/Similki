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
        Schema::create('satwa_titipans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lk')->nullable()->constrained('lembaga_konservasis')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_spesies')->constrained('list_species')->onDelete('cascade')->onUpdate('cascade');
            $table->string('no_bap_titipan')->unique();
            $table->foreignId('asal_satwa_titipan')->constrained('list_asal_satwa_titipans')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('jumlah_jantan');
            $table->integer('jumlah_betina');
            $table->integer('jumlah_unknown');
            $table->string('doc_bap_titipan');
            $table->text('path_bap_titipan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satwa_titipans');
    }
};
