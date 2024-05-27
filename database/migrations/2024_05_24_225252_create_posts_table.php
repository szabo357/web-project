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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            //relaciona el post con el id de usuario y si se elimina el usuario tambien 
            // se eliminaran sus publicaciones tambien.
            // user_id el sistema detecta automaticamente de que se trata de la tabla de usuarios      
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // guarda el contenido de la publicacion.
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
