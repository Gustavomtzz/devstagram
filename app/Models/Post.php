<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //Permisos para poder escribir en las columnas de la tabla post
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];



    //** METODOS PARA RELACIONAR MODELOS */

    //Relacionar MODELO USER
    public function user()
    {
        //BelongsTo es un metodo para RELACIONAR INVERSAMENTE los modelos.
        //En este caso muchos POST tiene un USUARIO CREADOR
        //SELECT permite seleccionar las COLUMNAS que QUEREMOS VER
        return $this->belongsTo(User::class)->select(['name', 'username', 'email']);
    }


    //Relacionar MODELO COMENTARIO
    public function comentarios()
    {
        //hasMany es un metodo para RELACIONAR ONE TO ONE/MORES los modelos.
        //En este caso un POST tiene muchos comentarios
        return $this->hasMany(Comentario::class);
    }

    //Relacionar MODELO LIKE
    public function likes()
    {
        //hasMany es un metodo para RELACIONAR ONE TO MANY.
        //En este caso un POST tiene muchos Likes
        return $this->hasMany(Like::class);
    }

    // Verificar si un USUARIO YA DIO LIKE
    public function checkLike(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }

    //Eliminar LIKE
    public function removeLike(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->delete();
    }
}
