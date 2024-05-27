<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function dashboard(Request $request){
        
        // $request->get('') nos devuelve un arreglo vacio.
        // $request->get('for-my') nos devuelve un arreglo con el 
        // id del usuario.
        //dd($request->get('for-my'));
        // Nos devuelve la informacion del usuario.
        //dd($request->user());
        
        // Imprimimos en pantalla la informacion de las relaciones
        // de amigos.
        // dd(
        //     $request->user()->friendsFrom()->get(),
        //     $request->user()->friendsTo()->get()    
        // );

        if($request->get("for-my")){
            
            //Obtenemos mi user id
            $user = $request->user();
            
            // Obtenemos los ids de mis amigos
            // $friends_from_ids = $user->friendsFrom()->pluck('users.id');
            // $friends_to_ids   = $user->friendsTo()->pluck('users.id');
            
            // Unimos todos los ids de mis amigos y mi id en un solo objeto.
            //Ahora ya tenemos la informacion necesaria para crear una consulta a la base de datos.
            //$user_ids = $friends_from_ids->merge($friends_to_ids)->push($user->id);
            
            //refactorizacion  para optimizar el metodo dashboard.  
            $user_ids = $user->friends()->pluck("id")->push($user->id);

            // muestra todos los ids en un solo objeto
            //dd($user_ids);
           
            // Esta es la primera forma de hacer el filtro.
            //$posts = Post::where("user_id", $request->user()->id)->latest()->get();
            
            //Esta es la segunda forma de hacer el filtro.
            //$posts = $request->user()->posts;
            
            // Esta es la tercera forma de obtener las publicacione en orden decendente.
            // Aqui obtengo solo mis publicaciones. 
            //$posts = $request->user()->posts()->latest()->get();
            
            // Ahora con esta consulta obtengo mis publicaciones y las publicaciones de mis amigos.
            $posts = Post::whereIn('user_id', $user_ids)->latest()->with('user')->get();

        }else{
        
            $posts = Post::latest()->with('user')->get();
        
        }

        // Manera extendida de hacer el return.
        //return view("dashboard", ["posts" => $posts]);

        // Manera abreviada de hacer el return usando la funcion compact
        return view("dashboard", compact('posts'));
        
    }

    public function profile(User $user){

        $posts = $user->posts()->latest()->get();
    
        return view("profile", compact('user', 'posts')); 
    }

    // Displays friends requests sent by other users and sent by me.
    public function status(Request $request){

        // Obtenemos las solicitudes de amistad pendientes.
        $requests = $request->user()->pendingTo;
        $sent     = $request->user()->pendingFrom;
        $friends  = $request->user()->friends();
        // $friends_from_ids = $user->friendsFrom()->pluck('users.id');
        // $friends_to_ids   = $user->friendsTo()->pluck('users.id');

        //dd($requests->pluck('users.id'), $sent->pluck('users.id'));

        return view("status", compact('requests', 'sent', 'friends'));
    }
}
