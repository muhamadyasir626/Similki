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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->string('nip', 20);
            $table->string('username', 50)->unique();
            $table->string('kodepos',5);
            $table->string('provinsi', 50);
            $table->string('kota_kab',50);
            $table->string('kecamatan', 50);
            $table->string('kelurahan', 50);
            $table->text('alamat_lengkap');
            $table->boolean('jenis_kelamin');  
            $table->string('nomor_telepon', 20)->unique();
            $table->string('email', 255)->unique();
            $table->foreignId('id_role')->constrained('roles','id_role')->onDelete('cascade');
            $table->foreignId('id_lk')->nullable()->constrained('lembaga_konservasis','id_lk')->onDelete('cascade');
            $table->foreignId('id_spesies')->nullable()->constrained('list_species','id_spesies')->onDelete('cascade');
            $table->foreignId('id_list_upt')->nullable()->constrained('list_upts','id_upt')->onDelete('cascade');
            $table->string('password', 255);
            $table->boolean('status_permission')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
