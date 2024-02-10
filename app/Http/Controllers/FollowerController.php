<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user)
    {
        //** Crear mediante ATTACH CUANDO RELACIONAS CON LA MISMA TABLA */
        /**
         *Utilizamos la libreria CARBON
         * para pasarle a las columnas created_at y updated_at
         * los valores, debido a que la tabla followers es una tabla intermedia
         * que no tiene su propio metodo create o update
         */
        $user->followers()->attach(auth()->user()->id, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        //** REDIRECIONAR A LA ROUTE 'posts.index' y pasamos un argumento de USERNAME para la url */
        return back();
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        //Buscar mediante el $Request->user(usuario autenticado) el $user del MURO y eliminarlo de la tabla INTERMEDIA;
        $user->followers()->detach(auth()->user()->id);

        return back();
    }
}
