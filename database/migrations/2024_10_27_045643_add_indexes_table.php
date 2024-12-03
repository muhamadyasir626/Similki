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
        Schema::table('users', function (Blueprint $table) {
            $table->unique('email');  
            $table->unique('username'); 
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
            $table->dropUnique('users_email_unique');
            $table->dropUnique('users_username_unique');
        });

        // Drop index untuk tabel satwas
        Schema::table('satwas', function (Blueprint $table) {
            $table->dropIndex(['satwas_id']);
            $table->dropIndex(['satwas_id_lk']);
            $table->dropIndex(['satwas_id_spesies']);
        });

        // Drop index untuk tabel lembagakonservasis
        Schema::table('lembagakonservasis', function (Blueprint $table) {
            $table->dropIndex(['lembagakonservasis_id']);
            $table->dropIndex(['lembagakonservasis_id_upt']);
        });

        // Drop index untuk tabel taggings
        Schema::table('taggings', function (Blueprint $table) {
            $table->dropIndex(['taggings_id']);
            $table->dropIndex(['taggings_id_satwa']);
        });

        // Drop index untuk tabel list_species
        Schema::table('list_species', function (Blueprint $table) {
            $table->dropIndex(['list_species_id']);
            $table->dropIndex(['list_species_spesies']);
        });

        schema::table('family_members', function(Blueprint $table){
            $table->dropIndex('family_members_id_ayah');
            $table->dropIndex('family_members_id_ibu');
            $table->dropIndex('family_members_id_anak');
            $table->dropIndex('family_members_id_pasangan');
        });

        schema::table('couples', function(Blueprint $table){
            $table->dropIndex('couples_id_jantan');
            $table->dropIndex('couples_id_betina');
        });
    }
};
