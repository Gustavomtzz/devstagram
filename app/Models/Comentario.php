<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;


    //Permisos para poder escribir en las columnas de la tabla post
    protected $fillable = [
        'user_id',
        'post_id',
        'comentario'
    ];


    //** RELACION de MUCHOS comentarios a un USUARIO */
    public function user()
    {
        return $this->belongsTo(User::class)->select(['username']);
    }
}
