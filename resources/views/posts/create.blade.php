@extends('layouts.app')

@section('titulo')
Crea tu Publicación
@endsection


@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@section('contenido')
<div class="px-5 md:flex md:items-center md:px-0">

    <div class="md:w-1/2 px-10">
        <form action="{{ route('imagenes.store') }}" id="dropzone" method="POST" enctype="multipart/form-data"
            class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center">
            @csrf
        </form>
    </div>

    <div class="md:w-1/2 px-10 rounded-lg shadow-xl bg-white p-5 mt-10 md:mt-3">
        <form action="{{route('posts.store') }}" method="POST">
            @csrf
            <!--Genera un Input "HIDDEN" con un "TOKEN" para EVITAR ATAQUES CSRF -->
            <div class="mb-5">

                <label for="titulo" class="mb-2 block uppercase text-gray-500 font-bold">Titulo</label>
                <input id="titulo" name="titulo" type="text" placeholder="Titulo de la Publicacion"
                    value="{{ old('titulo')}}"
                    class="border p-3 w-full rounded-lg @error('titulo') border-red-500 @enderror">

                @error('titulo')
                <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">
                    {{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">

                <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">Descripcion</label>
                <textarea name="descripcion" id="descripcion" cols="30" rows="4"
                    placeholder="Descripción de la Publicación"
                    class="border p-3 w-full rounded-lg resize-y @error('descripcion') border-red-500 @enderror">{{ old('descripcion')}}</textarea>

                @error('descripcion')
                <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">
                    {{ $message }}</p>
                @enderror

            </div>

            <div class="mb-5">

                <input type="hidden" name="imagen" id="imagen" value=" {{ old('imagen') }}">
                @error('imagen')
                <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">{{
                    $message }} </p>
                @enderror


            </div>

            <input type="submit" value="Crear Publicación"
                class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer mt-4 uppercase font-bold w-full p-3 rounded-lg text-white ">
        </form>

        </form>
    </div>

</div>
@endsection