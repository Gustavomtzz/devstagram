@extends('layouts.app')

@push('scripts')
<script src="https://kit.fontawesome.com/c450592c78.js" crossorigin="anonymous"></script>
@endpush

@section('titulo')
{{ $post->titulo }}
@endsection

@section('contenido')

<div class="container mx-auto p-4 md:flex gap-4 ">
    <div class="md:w-1/2">
        <img class="h-100 mx-auto" src="{{ asset('uploads') . '/' . $post->imagen  }}"
            alt="Imagen del Post {{ $post->titulo }}">

        <div class="md:flex justify-between p-3">
            {{-- Boton Likes --}}
            <div class="my-2 md:my-0 flex gap-2 items-center">
                {{-- Formulario Like --}}
                @auth

                <livewire:like-post :post="$post" />


                @endauth

            </div>
            <div class="flex gap-2 items-center">
                <p class="font-bold">{{ $post->user->username }}</p>
                <p class="text-sm text-gray-500"> {{
                    $post->created_at->diffForHumans()
                    }}
                </p>
            </div>
        </div>
        <p class="mt-5 shadow shadow-slate-500 p-2"> {{ $post->descripcion}}</p>
    </div>

    <div class="md:w-1/2 p-5">
        <div class="shadow bg-white p-5 mb-5">


            <p class="text-xl font-bold text-center mb-4">Comentarios</p>
            {{-- Variable 'mensaje' en la sesion --}}
            @if (session('mensaje'))
            {{-- Imprimimos un mensaje de 'COMENTARIO AÑADIDO CORRECTAMENTE' --}}
            <p class="bg-green-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">{{
                session('mensaje') }}</p>
            @endif

            {{--ITERAR todos los comentarios de un POST --}}
            @foreach ($post->comentarios as $comentario )

            <div class=" shadow-md shadow-slate-300 px-3 py-2 mb-3">
                {{-- EDITAR COMENTARIOS y ELIMINAR COMENTARIOS --}}
                @auth

                @if ($comentario->user_id === auth()->user()->id)

                <div class="flex justify-end gap-3 items-center">

                    <a id="btnComentarioEditar" data-id="{{$comentario->id}}"
                        class="fa-solid fa-pen-to-square cursor-pointer text-gray-600"></a>

                    <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="group cursor-pointer text-gray-600">
                            <i class="group-hover:animate-bounce group-hover:text-red-600 fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>

                @endif

                @endauth
                {{-- FIN EDITAR COMENTARIOS y ELIMINAR COMENTARIOS --}}
                <div class="py-2 md:flex justify-between text-gray-600">
                    <a href="{{ route('posts.index', $comentario->user) }}" class=" text-sm font-bold"> {{
                        $comentario->user->username }}</a>
                    <p class="text-sm"> {{ $comentario->created_at->diffForHumans() }}</p>
                </div>
                <p id="pComentario" class="text-xl"> {{$comentario->comentario }} </p>
            </div>

            @endforeach

            @auth
            {{-- FORMULARIO CREAR COMENTARIO --}}
            <form id="formularioCrearComentario" action="{{ route('posts.comentarios.store',['post' => $post]) }}"
                method="POST">
                @csrf
                <div class="m-5">

                    <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">Añade un
                        comentario...</label>
                    <textarea name="comentario" id="comentario" cols="30" rows="4"
                        placeholder="Comentario de la Publicación"
                        class="border p-3 w-full rounded-lg resize-y @error('comentario') border-red-500 @enderror"></textarea>
                    @error('comentario')
                    <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}</p>
                    @enderror

                </div>

                <input type="submit" value="Comentar"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer mt-4 uppercase font-bold w-full p-3 rounded-lg text-white" />
            </form>

            {{-- FORMULARIO ACTUALIZAR COMENTARIO --}}
            <form id="formularioEditarComentario" method="POST" class="hidden">
                @method('PATCH')
                @csrf
                <div class="m-5">

                    <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">Editar tu
                        comentario...</label>
                    <textarea name="comentario" id="comentario" cols="30" rows="4"
                        placeholder="Comentario de la Publicación"
                        class="border p-3 w-full rounded-lg resize-y @error('comentario') border-red-500 @enderror"></textarea>
                    @error('comentario')
                    <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}</p>
                    @enderror

                </div>

                <input type="submit" value="Editar"
                    class="bg-orange-600 hover:bg-orange-700 transition-colors cursor-pointer mt-4 uppercase font-bold w-full p-3 rounded-lg text-white" />
            </form>


            @endauth

            @guest
            <p class=" text-xl text-gray-500"> Logueate para añadir un comentario...</p>
            @endguest

        </div>
    </div>

</div>


@auth
<div class="text-end px-5">
    @if (auth()->user()->id === $post->user_id)
    <form action="{{route('posts.destroy', $post)}}" method="POST">
        {{-- AÑADIR Metodo DELETE, xq php no lo tiene por defecto --}}
        {{-- PREGUNTA PARA ENTREVISTA que es el metodo spoofing? --}}
        {{-- METODO SPOOFING te permite agregar otro tipo de peticiones como put/patch o delete --}}
        @method('DELETE')
        {{-- Evitar ataques CSRF --}}
        @csrf

        <!--Genera un Input "HIDDEN" con un "TOKEN" para EVITAR ATAQUES CSRF -->
        <button type="submit"
            class="text-white bg-red-500 hover:bg-red-700 group p-2 rounded font-bold mt-4 cursor-pointer"
            value="Eliminar Publicación"> <i class="group-hover:animate-bounce fa-solid fa-trash"></i> Eliminar
            Publicación</button>
    </form>
    @endif
</div>
@endauth
@endsection