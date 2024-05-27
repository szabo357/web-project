<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        "body",
    ] ;
    
    // Creamos una relacion que indica que un post le 
    // pertenece a un usuario. ahora con esto podremos 
    // recuperar el nombre del usuario al que pertenece
    // el post y tambien otra informacion que se encuentre 
    // almacenada en la tabla users.
    public function user(){
        return $this->belongsTo(User::class);
    }
}
