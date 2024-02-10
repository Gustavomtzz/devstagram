<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    //
    public function store(Request $request)
    {
        //Cerrar Sesión
        auth()->logout();
        //Redireccionar
        return redirect()->route('login');
    }
}
