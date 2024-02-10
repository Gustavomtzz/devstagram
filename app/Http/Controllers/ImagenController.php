<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ImagenController extends Controller
{
    //
    public function store(Request $request)
    {
        //OBTENER archivo de la imagen del FORMULARIO
        $imagen = $request->file('file');

        //CREAR un NOMBRE UNICO
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        //** VERSION v3 INTERVENTION IMAGE *//
        //CREAR un instancia nueva con un driver
        $imagenServidor = new ImageManager(new Driver());

        // LEER archivo(imagen) del FILE del form 
        $interventionImage =  $imagenServidor->read($imagen);

        // Escalar imagen a ancho y alto especifico
        $interventionImage->cover(1000, 1000);

        //Directorio para subir los archivos
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;

        //GUARDAR archivo en el directorio
        $interventionImage->save($imagenPath);

        //RESPUESTA que mandamos mediante JSON al cliente
        return response()->json(['imagen' => $nombreImagen]);
    }
}
