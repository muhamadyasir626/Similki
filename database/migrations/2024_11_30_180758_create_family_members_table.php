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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('jenis_kelamin'); //laki-laki (1) || perempuan (0)
            $table->foreignId('id_ayah')->nullable()->constrained('satwas')->onDelete('set null');
            $table->foreignId('id_ibu')->nullable()->constrained('satwas')->onDelete('set null');
            $table->foreignId('id_pasangan')->nullable()->constrained('satwas')->onDelete('set null');
            $table->foreignId('id_anak')->nullable()->constrained('satwas')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
