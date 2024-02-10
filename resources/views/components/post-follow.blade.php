<ul class="group relative dropdown cursor-pointer">
    <p class="font-bold"> {{ $user->count() }}
        <span class="font-normal">@if ($choice === "seguidores")
            @choice('Seguidor|Seguidores',$user->count())
            @else
            Siguiendo
            @endif
        </span>
    </p>
    <li
        class="group-hover:flex flex-col gap-4 z-10 shadow-lg shadow-gray-300 rounded-xl  bg-white p-4  absolute left-0 top-1 hidden h-auto">
        @foreach ($user as $follow )
        <a href="{{ route('posts.index', $follow->username)}}" class="flex gap-2 items-center font-bold capitalize"><img
                src="{{ $follow->imagen ? asset('perfiles/' . $follow->imagen) : asset('img/usuario.svg')}}"
                alt="Imagen del usuario" class="h-9 w-9 rounded-full" />{{
            $follow->username}}</a>
        @endforeach
    </li>
</ul>