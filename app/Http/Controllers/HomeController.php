<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        if (auth()->user()) {

            /**
             * Traigo los IDS de las personas que SIGO
             * pluck() sirve para traer ciertos CAMPOS
             * toArray() transforma en un array el objeto que trae
             */
            $users = auth()->user()->follow->pluck('id')->toArray();

            /** 
             * Busco los POSTS de los usuarios con su respectivo id
             * paginate() sirve para traer cierta cantidad para mostrar en la vista
             * whereIn($columna, $ArraydeValores) filtra una columna con el ARRAY de valores dado
             * diferente a where($columna, $valor) filtra una columna por el UNICO valor dado
             * orderBy($columna, $orden['desc'->desendente, 'asc'->ascendente]) sirve para ordenar asc/desc los registros
             * latest() es como orderBy pero automaticamente ordena las ultimas entradas primero 
             * $posts = Post::whereIn('user_id', $users)->latest()->paginate(10);
             */
            $posts = Post::whereIn('user_id', $users)->orderBy('created_at', 'desc')->paginate(10);


            return view('principal', ['posts' => $posts]);
        }

        return view('principal');
    }
}
