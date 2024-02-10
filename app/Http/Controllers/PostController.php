<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    //Mostrar el Panel
    public function index(User $user)
    {
        //** FORMA MAS ORIENTADA RELACION ENTRE TABLAS */
        //ALERTA.... ESTA MANERA NO PERMITE LA PAGINACIÓN (FILTRAR POR PAGINAS) los posts
        // return VIEW SOLO PASAMOS user como argumento


        //** FORMA 1 DE TRAER TODOS LOS POSTS PARA MOSTRARLOS MAS ORIENTADO AL MODELO DE ELOQUENT*/
        //GET es para traer los datos y no solamente el modelo

        // $posts = Post::where('user_id', $user->id)->get();

        /** FORMA 2 DE TRAER TODOS LOS POSTS Y LIMITAR LA CANTIDAD PARA VER MEDIANTE PAGINAS. EJ ver 10 post y pagina siguiente otros 10 etc */
        //** PAGINACION mediante ->PAGINATE('LIMITE a traer') o ->simplePaginate('Limite a Traer')*/
        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(5);

        $seguidos = Follower::where('follower_id', $user->id);

        return view('posts.index', [
            'user' => $user,
            'posts' => $posts,
            'seguidos' => $seguidos
        ]);
    }

    public function create(User $user)
    {
        return view('posts.create', [
            'user' => $user
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:100',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);


        // // ** Crear Registros Forma 1 */
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);


        //** Crear Registros Forma 2 */

        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;

        //** Guardar en la base de datos Forma 2 */
        // $post->save();

        //** Crear Registros Forma 3 con MODELOS RELACIONADOS */

        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        //** REDIRECIONAR A LA ROUTE 'posts.index' y pasamos un argumento de USERNAME para la url */
        return redirect()->route('posts.index', auth()->user()->username);
    }


    public function show(User $user, Post $post)
    {

        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Request $request, Post $post)
    {

        // Forma de VERIFICAR si un Usuario puede eliminar el post
        $this->authorize('delete', $post);

        // if ($request->user()->cannot('delete', $post)) {
        //     abort(403, 'No tienes permisos concedidos');
        // } else {

        //** Borrar Imagen*/
        //   Directorio de la imagen
        $path = public_path('uploads' . '/' . $post->imagen);

        // Verificar si existe la imagen    
        if (File::exists($path)) {

            //Eliminar la Imagen
            unlink($path);
        }

        //Borrar Registro de la BD
        $post->delete();
        //** REDIRECIONAR A LA ROUTE 'posts.index' y pasamos un argumento de USERNAME para la url */
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
