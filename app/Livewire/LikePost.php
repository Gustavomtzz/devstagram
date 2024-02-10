<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{

    public $post;
    public $isLiked;
    public $likes;

    //**  mount() es exactamente lo mismo que __construct
    // Se llama automaticamente cuando se instancia un objeto de esta clase

    public function mount($post)
    {
        //Verificamos si ya dio like el usuario autenticado
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like()
    {
        //Verificarque el USUARIO ya le haya dado LIKE

        if ($this->post->checkLike(auth()->user())) {

            // Eliminar Like
            $this->post->removeLike(auth()->user());
            $this->isLiked = false;
            $this->likes--;
            //** REETORNAMOS A  'posts.show' y pasamos un MENSAJE */
            return back();
        }

        //Creamos el Like
        $this->post->likes()->create([
            'user_id' => auth()->user()->id
        ]);
        $this->isLiked = true;
        $this->likes++;

        //** REETORNAMOS A  'posts.show' y pasamos un MENSAJE */
        return back();
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
