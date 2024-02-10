@extends('layouts.app')

@section('titulo')
Editar Perfil: <span class="text-red-500 capitalize">{{ $user->username}}</span>
@endsection

@section('contenido')
<div class="md:flex md:justify-center mt-4">

    <div class="md:w-1/2 bg-white shadow p-6">

        <form action="{{ route('perfil.store',$user)}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-5">
                <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">Usuario:</label>
                <input type="text" id="username" name="username" placeholder="Tu usuario"
                    value="{{ auth()->user()->username }}"
                    class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror">
                @error('username')
                <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">{{
                    $message
                    }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">Imagen de Perfil:</label>
                <input type="file" accept="image/jpeg, image/png,/ image/jpg" id="imagen" name="imagen"
                    class="border p-3 w-full rounded-lg">

            </div>


            <input type="submit" value="Guardar cambios"
                class=" w-full bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer mt-4 uppercase font-bold p-3 rounded-lg text-white">


        </form>

    </div>

</div>
@endsection