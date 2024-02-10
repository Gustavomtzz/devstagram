<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PerfilController extends Controller
{


    public function index(User $user)
    {
        $this->authorize('editar-perfil', $user);
        return view('perfil.index', ['user' => auth()->user()]);
    }


    public function store(Request $request)
    {

        //Modificar username
        $request->request->add([
            'username' => Str::slug($request->username)
        ]);

        /*
        * Cuando son mas de 3 REGLAS PARA VALIDAR, laravel recomienda agruparlas en un ARRAY
        * not_in Sirve para prohibir valores no deseados
        * "not_in:twitter,facebook,elon musk" prohibe utilizar esas palabras como nombre de usuario.
        * in Obliga al usuario a que elija valores de un array
        * "in:cliente,proveedor,dueño" obliga a que en el nombre de usuario incluya alguno de esos valores Clientegustavo2411. 
        */
        $this->validate($request, [
            'username' => ['required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:30', 'not_in:twitter,facebook,instagram']
        ]);


        //Verificar y Guardar Imagen en caso de que exista
        if ($request->file('imagen')) {

            //Verificar si esta lleno la columna de imagen
            if (!empty($request->user()->imagen)) {

                $imagenPath = public_path('perfiles/' . $request->user()->imagen);

                //Verificar que exista el Archivo
                if (File::exists($imagenPath)) {

                    //Borrar imagen anterior
                    File::delete($imagenPath);
                }
            }

            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . '.' . $imagen->extension();


            $imagenServidor = new ImageManager(new Driver());

            // LEER archivo(imagen) del FILE del form 
            $interventionImage =  $imagenServidor->read($imagen);

            // Escalar imagen a ancho y alto especifico
            $interventionImage->cover(500, 500);


            //Comprobacion de Archivo
            // if (!File::exists(public_path('uploads/' . $request->username))) {

            //     File::makeDirectory(public_path('uploads/' . $request->username));
            // }

            //Directorio para subir los archivos
            $imagenPath = public_path('perfiles/') . $nombreImagen;

            //GUARDAR archivo en el directorio
            $interventionImage->save($imagenPath);

            $request->user()->update([
                'username' => $request->username,
                'imagen' => $nombreImagen
            ]);

            return redirect()->route('posts.index', auth()->user()->username);
        }

        $request->user()->update([
            'username' => $request->username,
            'imagen' => auth()->user()->imagen ?? null
        ]);


        return redirect()->route('posts.index', auth()->user()->username);
    }
}
