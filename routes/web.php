<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// dashboard ahora sera el root de nuestro proyecto
//Route::get("/", [PageController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');


// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Esto nos permite eficientar nuestro codigo de rutas
    // Esta es la ruta nueva hacia nuestro dashboard.
    Route::get("/", [PageController::class, 'dashboard'])->middleware( 'verified')->name('dashboard');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Esta ruta nos permitira agregar un nuevo amigo
    Route::post('/friends/{user}', [FriendController::class, 'store'])->name('friends.store');

    // Esta ruta nos permitira actualizar el estado de la solicitud de amistad.
    Route::put('/friends/{user}', [FriendController::class, 'update'])->name('friends.update');


    // Nueva ruta para creacion de publicaciones
    // posts.stores es el nombre de la ruta
    // store es el metodo que esta dentro de PostController
    // '/posts' es el uri.
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Ruta que nos lleva al perfil de usuario
    Route::get('/profile/{user}', [PageController::class, 'profile'])->name('profile.show');

    // Ruta que nos llevara a la pagina central
    Route::get('/status', [PageController::class, 'status'])->name('status');
    
});

require __DIR__.'/auth.php';
