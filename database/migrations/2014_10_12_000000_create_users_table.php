<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.-
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->index('nama_lengkap');
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
            $table->foreignId('id_role')->constrained('roles')->onDelete('cascade')->onUpdate('cascade');
            // $table->index('id_role');
            $table->foreignId('id_lk')->nullable()->constrained('lembaga_konservasis')->onDelete('cascade')->onUpdate('cascade');
            // $table->index('id_lk');
            $table->foreignId('id_spesies')->nullable()->constrained('list_species')->onDelete('cascade')->onUpdate('cascade');
            // $table->index('id_spesies');
            $table->foreignId('id_upt')->nullable()->constrained('list_upts')->onDelete('cascade')->onUpdate('cascade');
            // $table->index('id_upt');
            $table->string('password', 255);
            $table->boolean('status_permission')->default(false)->index();
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
