<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    //Metodo STORE para Almacenar un registro nuevo de un comentario
    public function store(Request $request,  User $user, Post $post)
    {


        $this->validate($request, [
            'comentario' => 'required|max:255'
        ]);

        // ** Crear Registros de Comentario*/

        /*
        * USUARIO LOGEADO es el user_id que crea el comentario
        * POST_ID es el post donde fue creado el comentario
        * Comentario desde la solicitud POST del Formulario en la vista show.blade.php
        */
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);


        //** REETORNAMOS A  'posts.show' y pasamos un MENSAJE */
        return back()->with('mensaje', 'Comentario añadido correctamente');
    }

    public function update(Request $request, Comentario $comentario)
    {
        $this->authorize('update', $comentario);

        $this->validate($request, [
            'comentario' => 'required|max:255'
        ]);

        $comentario->update([
            'comentario' => $request->comentario,
        ]);
        return back();
    }


    public function destroy(Comentario $comentario)
    {
        $this->authorize('delete', $comentario);
        $comentario->delete();
        return back();
    }
}
