<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'imagen'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    //** METODO PARA RELACIONAR MODELOS */
    public function posts()
    {
        //hasMany es un metodo para RELACIONAR ONE TO ONE los modelos.
        //En este caso un Usuario tiene muchos POST
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }


    //Almacena los que me siguen
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    //Almacena los que seguimos
    public function follow()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }



    //Verificar si seguimos a un usuario de un muro y mostrar dejar de seguir
    public function siguiendo(User $user)
    {
        return $this->followers->contains($user->id);
    }
}
