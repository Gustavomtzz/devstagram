@extends('layouts.app')

@push('scripts')
<script src="https://kit.fontawesome.com/c450592c78.js" crossorigin="anonymous"></script>
@endpush


@section('titulo')
Perfíl: {{ $user->username}}
@endsection


@section('contenido')
<div class="flex justify-center">
    <div class="w-6/12 md:w-8/12 lg:w-6/12 md:flex">

        <div class="md:w-8/12 lg:w-6/12 px5">
            <img src="{{ $user->imagen ? asset('perfiles/' . $user->imagen) : asset('img/usuario.svg') }}"
                alt="imagen usuario" class="rounded-full">
        </div>

        <div class="md:w-8/12 lg:w-6/12 flex flex-col items-center justify-center py-10 md:py-0 md:items-start px-5">
            <div class="flex gap-2 items-center">
                <p class="text-gray-700 text-2xl font-bold mb-4"> {{ $user->username}} </p>
                @auth
                @if ($user->id === auth()->user()->id)

                <a href="{{ route('perfil.index', $user) }}"
                    class="fa-solid fa-pencil cursor-pointer text-gray-600"></a>
                @endif
                @endauth
            </div>


            <!--Informacion Muro-->
            <div class="flex flex-col gap-3 my-2 w-full">

                {{-- Seguidores --}}
                <x-post-follow :user="$user->followers" choice="seguidores" />

                {{-- Seguidos --}}
                <x-post-follow :user="$user->follow" />

                {{-- Posts Creados --}}
                <p class="text-gray-800 text-sm my-1 font-bold">{{ $user->posts->count() }}
                    <span class="font-normal">@choice('Post|Posts',$user->posts->count())</span>
                </p>

            </div>

            {{-- MOSTRAR BOTON SEGUIR/DEJAR DE SEGUIR --}}
            @auth
            <div class="flex justify-end gap-3 my-4">
                @if ($user->id !== auth()->user()->id)

                @if (!$user->siguiendo(auth()->user()))
                <form action="{{ route('user.follow.store', ['user'=>$user]) }}" method="POST">
                    @csrf
                    <input type="submit" value="Seguir"
                        class="cursor-pointer font-semibold rounded-lg px-4 py-2 text-white   bg-blue-500 hover:bg-blue-800">
                </form>
                @else
                <form action="{{ route('user.unfollow.destroy', ['user'=>$user]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="submit" value="Dejar de Seguir"
                        class="cursor-pointer font-semibold rounded-lg px-4 py-2 text-white   bg-red-500 hover:bg-red-800">
                </form>
                @endif
                @endif
            </div>
            @endauth

        </div>
    </div>
</div>




<section class="container mx-auto mt-10">
    <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>

    {{-- Mostrar alerta si no hay posts creados --}}
    @if ($posts->count() == 0)
    <p class="text-xl text-center uppercase my-10 text-gray-600 font-bold">No hay publicaciones <br> Creá una <a
            href="{{ route('posts.create')}}" class="text-red-600 ">Aquí</a></p>

    @endif

    {{-- Iterar los POSTS y publicarlos en el el Perfil mediante la IMAGEN del post--}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 img-fluid px-5">
        @foreach ($posts as $post )
        <x-listar-post :post="$post" />
        @endforeach
    </div>

    {{-- Paginación.... (Siguiente--Anterior) segun cantidad de posts --}}
    <div class="my-5">
        {{-- ->Links('Diseño de la barra de siguiente y anterior, tailwind o bootstrap o default') es el metodo para
        realizar la paginacion --}}
        {{ $posts->links('pagination::tailwind')}}
    </div>
</section>



@endsection