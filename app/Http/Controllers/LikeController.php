<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //

    public function store(Request $request, Post $post)
    {

        // //Verificarque el USUARIO ya le haya dado LIKE

        // if ($post->checkLike($request->user())) {

        //     // Eliminar Like
        //     $post->removeLike($request->user());

        //     //** REETORNAMOS A  'posts.show' y pasamos un MENSAJE */
        //     return back();
        // }


        // //SI NO EXISTE un LIKE con el usuario authenticado. Permitimos dar LIKE

        // // ** Crear Registros de LIKES*/
        // //USUARIO LOGEADO es el user_id que LIKEA
        // //POST_ID es el post donde fue LIKEADO

        // // Like::create([
        // //     'user_id' => $request->user()->id,
        // //     'post_id' => $post->id
        // // ]);

        // // Otra forma de crear el LIKE mediante RELACION DE MODELOS
        // $post->likes()->create([
        //     'user_id' => $request->user()->id
        // ]);

        // //** REETORNAMOS A  'posts.show' y pasamos un MENSAJE */
        // return back();
    }
}
