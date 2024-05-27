<?php

namespace App\Http\Controllers;

// Agregamos el modelo con el que vamos a trabajar
//use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function store(Request $request){
        
        //Validamos que el post no este vacío.
        $request->validate([
           'body' => 'required'
        ]);

        $request->user()->posts()->create($request->all());

        return back();
    }
}
