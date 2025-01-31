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
        Schema::create('Histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');  
            $table->enum('action',['create','update','delete','verification']);  
            $table->enum('model_type',['satwa','lembaga konservasi']);  
            $table->foreignId('id_satwa')->constrained('satwa')->nullable();  
            $table->foreignId('id_lk')->constrained('lembaga_konservasi')->nullable();  
            $table->string('messages')->nullable();
            $table->json('old_data')->nullable();  
            $table->json('new_data')->nullable();  
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
