@extends('layouts.app')

@section('titulo')
Logeate
@endsection


@section('contenido')
<div class=" p-5  md:flex md:justify-center md:p-0 md:gap-5 md:items-center ">
    <div class="md:w-6/12 mb-4 md:mb-0">
        <img src="{{ asset('img/login.jpg') }}" alt="Registro de Usuarios" class="rounded-lg">
    </div>

    <div class="md:w-6/12 rounded-lg shadow-xl bg-white p-5">
        <form action="{{route('login') }}" method="POST">
            @csrf
            <!--Genera un Input "HIDDEN" con un "TOKEN" para EVITAR ATAQUES CSRF -->
            @if (session('mensaje'))
            <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">{{
                session('mensaje') }}</p>
            @endif

            <div>
                <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">Email</label>
                <input id="email" name="email" type="email" placeholder="Tu Email" value="{{ old('email')}}"
                    class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror" autocomplete="on">
                @error('email')
                <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">{{
                    $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Password</label>
                <input id="password" name="password" type="password" placeholder="Tu Password"
                    value="{{ old('password')}}"
                    class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror" autocomplete="off">
                @error('password')
                <p class="bg-red-500 text-white uppercase font-semibold my-2 rounded-lg text-sm p-2 text-center">{{
                    $message }}</p>
                @enderror
            </div>

            <div class="mt-4 md:flex gap-2">
                <input type="checkbox" name="remember" id="remember"><label class="text-gray-500" for=" remember">
                    Mantener sesión
                    iniciada</label>
            </div>

            <input type="submit" value="Iniciar Sesión"
                class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer mt-4 uppercase font-bold w-full p-3 rounded-lg text-white ">
        </form>


    </div>

</div>
@endsection