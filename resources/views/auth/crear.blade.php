@extends('layouts.app')

@section('titulo')
Regístrate en Devstagram
@endsection

@section('contenido')
<div class=" p-5  md:flex md:justify-center md:p-0 md:gap-5 md:items-center ">
    <div class="md:w-6/12 mb-4 md:mb-0">
        <img src="{{ asset('img/registrar.jpg') }}" alt="Registro de Usuarios" class="rounded-lg">
    </div>

    <div class="md:w-6/12 rounded-lg shadow-xl bg-white p-5">
        <form action="{{route('registro') }}" method="POST">
            @csrf <!--Genera un Input "HIDDEN" con un "TOKEN" para EVITAR ATAQUES CSRF -->
            <div class="mb-5">
                <label for="nombre" class="mb-2 block uppercase text-gray-500 font-bold">Nombre</label>
                <input id="nombre" name="name" type="text" placeholder="Tu Nombre" 
                value="{{ old('name')}}" 
                class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror" 
                autocomplete="off">

                @error('name')
                    <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label  for="username" class="mb-2 block uppercase text-gray-500 font-bold">Usuario</label>
                <input id="username" name="username" type="text" placeholder="Tu Usuario"
                value="{{ old('username')}}"
                class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror" autocomplete="off">
                @error('username')
                <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
            </div>
            <div>
                <label  for="email" class="mb-2 block uppercase text-gray-500 font-bold">Email</label>
                <input id="email" name="email" type="email" placeholder="Tu Email"
                value="{{ old('email')}}"
                class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror" autocomplete="off">
                @error('email')
                <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
            </div>
            <div>
                <label  for="password" class="mb-2 block uppercase text-gray-500 font-bold">Password</label>
                <input id="password" name="password" type="password" placeholder="Tu Password"
                value="{{ old('password')}}"
                class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror" autocomplete="off">
                @error('password')
                <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
            </div>
            <div>
                <label  for="password_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">Repetir Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Repetir Password" class="border p-3 w-full rounded-lg" autocomplete="off">
            </div>




        <input type="submit" value="Crear Cuenta" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer mt-4 uppercase font-bold w-full p-3 rounded-lg text-white ">
        </form>


    </div>
    


</div>
@endsection