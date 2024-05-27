<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    // Nos permite hacer una solicitud de amistad.
    public function store(Request $request, User $user){

        // Optimizacion : usamos el metodo is related que viene a reemplazar
        // el codigo restante en este metodo 
        // ahora hacemos la pregunta 
        // si no estamos relacionados entonces hacemos el attach
        // caso contrario go back().
        if(!$request->user()->isRelated($user)){
            $request->user()->from()->attach($user);
        }
      
        // El dd nos permite ver en pantalla la informacion 
        // con la que estamos trabajando y de esta forma verificar
        // si lo que estamos haciendo está correcto.
        // dd(
        //     //Mi id
        //     $request->user()->id,
        //     // Id de la persona con la quiero amistad
        //     $user->id,
        //     // Revisamos las comprobaciones
        //     $request->user()->from()->where('to_id',$user->id)->exists(),
        //     $request->user()->to()->where('from_id',$user->id)->exists()
        // );

        //Para evitar duplicados de amistad en nuestra tabla friends hacemos las siguientes consultas
        // $is_from o $is_to retornaran true si ya existe la relacion en friends
        //$is_from = $request->user()->from()->where('to_id',$user->id)->exists();
        //$is_to   = $request->user()->to()->where('from_id',$user->id)->exists();

        // Si las relaciones existen go back.
        //if($is_from || $is_to){
        //    return back();
        //}

        // Validación que evita que el usuario se envie solicitud de amistad a si mismo.
        //if($request->user()->id === $user->id){

        //    return back();    
        //}

        // enviamos la solicitud de amistad.
        //$request->user()->from()->attach($user);

        return back();
    }

    // Aceptamos la peticion de amistad
    public function update(Request $request, User $user){
        
        // Consultas para revisar la informacion entrante al metodo.
        // dd(
        //     $user->id,
        //     $request->user()->pendingTo,
        //     $request->user()->pendingTo()->where('from_id', $user->id)
        // );
        
        // Acceptamos la peticion de amistad.
        //Primera forma de hacerlo.
        //$request->user()->pendingTo()->where('from_id', $user->id)->update(['accepted' => true]);
        
        // Segunda forma de aceptar la peticion de amistad.
        $request->user()->pendingTo()->updateExistingPivot($user, ['accepted' => true]);
        
        return back();
    }

}
