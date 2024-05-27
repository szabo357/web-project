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
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            // Quien hace la solicitud de amistad 
            // En este caso para que el sistema detecte que from_id pertenece a la tabla
            // users se lo tengo que indicar manualmente  pasando el nombre de la tabla
            // como parametro constrained('users'). lo mismo sucede con to_id.
            $table->foreignId('from_id')->constrained('users')->onDelete('cascade');
            // Quien recibe esa solicitud de amistad
            $table->foreignId('to_id')->constrained('users')->onDelete('cascade');
            // Indica si la solicitud de amistad ha sido aceptada.
            $table->boolean('accepted')->default(false);

            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
