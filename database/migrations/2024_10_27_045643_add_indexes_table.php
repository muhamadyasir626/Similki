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
        // Index untuk tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->unique('email', 'unique_email');  
            $table->unique('username', 'unique_username'); 
        });

        // Index untuk tabel satwas
        Schema::table('satwas', function (Blueprint $table) {
            $table->index('id');
            $table->index('id_lk');
            $table->index('id_spesies');
        });

        // Index untuk tabel lembagakonservasis
        Schema::table('lembaga_konservasis', function (Blueprint $table) {
            $table->index('id');
            $table->index('id_upt');
        });

        // Index untuk tabel taggings
        Schema::table('taggings', function (Blueprint $table) {
            $table->index('id');
            $table->index('id_satwa');
        });

        // Index untuk tabel list_species
        Schema::table('list_species', function (Blueprint $table) {
            $table->index('id');
            $table->index('spesies');
        });

        schema::table('family_members', function(Blueprint $table){
            $table->index('id_ayah');
            $table->index('id_ibu');
            $table->index('id_anak');
            $table->index('id_pasangan');
        });

        schema::table('couples', function(Blueprint $table){
            $table->index('id_jantan');
            $table->index('id_betina');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop unique index untuk tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('unique_email');
            $table->dropUnique('unique_username');
        });

        // Drop index untuk tabel satwas
        Schema::table('satwas', function (Blueprint $table) {
            $table->dropIndex(['id']);
            $table->dropIndex(['id_lk']);
            $table->dropIndex(['id_spesies']);
        });

        // Drop index untuk tabel lembagakonservasis
        Schema::table('lembagakonservasis', function (Blueprint $table) {
            $table->dropIndex(['id']);
            $table->dropIndex(['id_upt']);
        });

        // Drop index untuk tabel taggings
        Schema::table('taggings', function (Blueprint $table) {
            $table->dropIndex(['id']);
            $table->dropIndex(['id_satwa']);
        });

        // Drop index untuk tabel list_species
        Schema::table('list_species', function (Blueprint $table) {
            $table->dropIndex(['id']);
            $table->dropIndex(['spesies']);
        });

        schema::table('family_members', function(Blueprint $table){
            $table->dropIndex('id_ayah');
            $table->dropIndex('id_ibu');
            $table->dropIndex('id_anak');
            $table->dropIndex('id_pasangan');
        });

        schema::table('couples', function(Blueprint $table){
            $table->dropIndex('id_jantan');
            $table->dropIndex('id_betina');
        });
    }
};
