<?php

use App\Livewire\LikePost;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ComentarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/** 
 * El controlador HomeController al poseer un solo metodo(metodo "index")
 * podemos utilizar en el controlador propio, el metodo "__invoke"
 * lo que seria como un "__construct" que se manda a llamar automaticamente
 * entonces, nos ahorramos de pasarle el nombre del metodo a la llamada a la fúncion
 */
Route::get('/', HomeController::class)->name('index');

Route::get('/registro', [RegisterController::class, 'index'])->name('registro');
Route::post('/registro', [RegisterController::class, 'store']);


//** LOGIN PANEL */
//Utilizando PREFIX('ruta'). Prefix sirve para cuando una misma palabra en la ruta se repite.
//En este EJ: usamos la url 'login' tanto para el metodo GET como POST
// El echo del get('/') seria "http:://localhost:3030/login"
Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
/**FIN LOGIN PANEL */

//** PERFIL DE USUARIO*/
//ACCESO PUBLICO
Route::group([], function () {
    //Route Model Binding. Pasamos una variable y la consulta automaticamente
    Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
    //Route Model Binding. Tambien permite mas variables y mas Modelos Diferentes para consultar automaticamente
    Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
});

/*
* ACCESO PRIVADO
* Podemos UTILIZAR el metodo middleware('pasarle el que necesitemos EJ:auth') y encadenar con el metodo group()
* para verificar si el usuario esta authenticado para un GRUPO de URL'S. Por ejemplo el Perfil del usuario y las demas
*/
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});
//** FIN PERFIL DE USUARIO */

//** EDITAR PEFIL */
Route::middleware('auth')->group(function () {
    Route::get('/{user:username}/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::Post('/{user:username}/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');
});
//** FIN EDITAR PERFIL */


/**SEGUIDORES Y SIGUIENDO */
Route::middleware('auth')->group(function () {
    Route::Post('/{user:username}/follow', [FollowerController::class, 'store'])->name('user.follow.store');
    Route::Delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('user.unfollow.destroy');
});

/** FIN SEGUIDORES Y SIGUIENDO */


/** POSTS FUNCIONALIDADES */
//** COMENTARIOS */
Route::middleware('auth')->group(function () {
    Route::Post('/posts/{post}/comentario', [ComentarioController::class, 'store'])->name('posts.comentarios.store');
    Route::patch('/comentarios/{comentario}', [ComentarioController::class, 'update'])->name('comentarios.update');
    Route::Delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');
});

//** LIKES */
Route::middleware('auth')->group(function () {
    Route::post('/posts/like', [LikePost::class]);
});

/**FIN POST FUNCIONALIDADES */

//Imagenes Store
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');
