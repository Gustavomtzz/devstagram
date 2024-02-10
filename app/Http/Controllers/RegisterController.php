<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //Mostrar Registro de Usuarios
    public function index()
    {

        return view('auth.crear');
    }


    //Registro de Usuarios Formulario
    public function store(Request $request)
    {

        //Modificar username
        $request->request->add([
            'username' => Str::slug($request->username)
        ]);

        //Válidacion
        $this->validate($request, [
            //'name' => ['requiered', 'min:5'] //Otra Sintaxis para pasar la validación
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:30',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);

        //Crear Usuario
        User::create(
            [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password

            ]
        );

        //Autenticar un Usuario
        Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        //Reedireccionar
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
