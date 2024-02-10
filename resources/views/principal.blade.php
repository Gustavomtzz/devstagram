@extends('layouts.app')

@section('titulo')
{{ auth()->user() ? "Bienvenido a tu muro" : "Únete a nuestra comunidad"}}
@endsection

@section('contenido')
@auth


<div class="lg:grid grid-cols-2">

    @forelse ( $posts as $post )
    <div class="m-2 p-3 shadow-lg  bg-white rounded-md">
        <x-listar-post :post="$post" />

        <div class="my-3 w-full flex flex-col gap-2 justify-center lg:justify-around">

            <div class="flex justify-between">
                <p class="font-bold text-gray-600"> {{$post->user->username}} </p>
                <p class="text-gray-600">{{$post->created_at->diffForHumans()}}</p>
            </div>

            <div>
                <p> {{$post->titulo}} </p>
                <p> {{ $post->descripcion}} </p>
            </div>

        </div>
    </div>

    @empty
    <div class="text-center">
        <p class="font-bold">No hay Posts a mostrar</p>
    </div>

    @endforelse

</div>

<div>
    {{$posts->links('pagination::tailwind') }}
</div>

@endauth

@endsection