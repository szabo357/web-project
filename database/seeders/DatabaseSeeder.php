<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // De esta manera vamos a crear 20 usuarios nuevos
        // y queremos saber el correo del primero para poder 
        // iniciar sesion.
        User::factory()->create(['email' => 'test@mail.com']);
        // Estos usuarios tendran 4 posts. pero para ello se tiene 
        // que registar la relacion de las tablas 
        // La base de datos sabe que un usuario puede tener muchas publicaciones
        // la base de datos tambien conoce que una publicacion pertenece a un usuario.
        // pero Laravel no. asi que manualmente se debe escribir esa relacion dentro de Models/User.php 
        User::factory(19)->hasPosts(4)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
