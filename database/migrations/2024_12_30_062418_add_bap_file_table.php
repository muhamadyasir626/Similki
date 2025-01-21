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
            $table->string('bap_file'); // menambahkan kolom bap_file
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('satwas', function (Blueprint $table) {
            $table->dropColumn('bap_file'); // menghapus kolom bap_file jika migrasi dibatalkan
        });
    }
};
