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
            $table->string('jumlah_satwa_jantan'); // menambahkan kolom jumlah_satwa_jantan
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('satwas', function (Blueprint $table) {
            $table->dropColumn('jumlah_satwa_jantan'); // menghapus kolom jumlah_satwa_jantan jika migrasi dibatalkan
        });
    }
};
