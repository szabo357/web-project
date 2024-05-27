<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // De esta forma indicamos a Laravel que un usuario puede tener
    // muchas publicaciones.     
    public function posts(){
        return $this->hasMany(Post::class);
    }    

    // De esta forma hacemos la relación entre los usuarios 
    // y saber si son amigos. Esta es la manera basica.
    // public function friends(){
    //     return $this->BelongsToMany(User::class, 'friends','from_id','to_id');
    // }

    //Relacion normal (configuramos las relaciones los usuarios hayan acepado o no)
    // Este es el caso que el usuarioA envie solicitud de amistad al usuarioB
    public function from(){
        return $this->belongsToMany(User::class,'friends','from_id','to_id');
    }

    //Relacion normal (configuramos las relaciones los usuarios hayan acepado o no)
    // Este es el caso que el usuarioB envie solicitud de amistad al usuarioA
    public function to(){
        return $this->belongsToMany(User::class,'friends','to_id','from_id');
    }
   
    public function isRelated(User $user){

        // Si el usuario autenticado soy yo mismo, entonces,
        // retorno true para ocultar el boton de solicitud de amistad
        // porque significa que estoy viendo mi perfil
        if( Auth()->user()->id === $user->id){
            return true;
        }

        // Pregunta a la base de datos si existe relacion entre el usuario autenticado y el id de usuario que recibimos como
        // parametro desde la vista 'profile.blade.php'
        return $this->from()->where('to_id', $user->id)->exists() || $this->to()->where('from_id', $user->id)->exists();
    }

    // Devuelve un objeto que contiene todos mis amigos.
    public function friends(){

        return $this->friendsFrom->merge($this->friendsTo);
    }

    // Solicitudes de amistad que el usuario ha aceptado

    // Relacion donde El UsuarioA ha aceptado la amistad del UsuarioB
    public function friendsFrom(){
        return $this->from()->wherePivot('accepted', true);
    }

    // Relacion donde El usuarioB ha aceptado la amistad del UsuarioA
    public function friendsTo(){
        return $this->to()->wherePivot('accepted', true);
    }

    // Solicitudes de amistad que el usuario aun no ha aceptado.
    public function pendingFrom(){
        return $this->from()->wherePivot('accepted', false);
    }

    public function pendingTo(){
        return $this->to()->wherePivot('accepted', false);
    }

}
