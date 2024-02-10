<a href="{{route('posts.show', ['user'=>$post->user, 'post'=>$post])}}">
    <img src="{{ $post->imagen ? asset('uploads/' . $post->imagen) : asset('img/usuario.svg')  }}"
        alt="Imagen del $post->titulo" class=" w-full h-auto ">
</a>