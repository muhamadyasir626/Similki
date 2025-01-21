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
        Schema::table('satwas', function (Blueprint $table) {
            $table->string('nama_lokal'); // menambahkan kolom nama_lokal
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('satwas', function (Blueprint $table) {
            $table->dropColumn('nama_lokal'); // menghapus kolom nama_lokal jika migrasi dibatalkan
        });
    }
};
