<div>

    <button wire:click="like" class="btn btn-success hover:scale-125">
        <i @if ($isLiked) class="fa-solid fa-heart" style="color: #e60f3a;" @else class="fa-regular fa-heart" @endif>
        </i>
    </button>
    @if($likes)
    <p class="text-sm inline-block">
        {{ $likes . " Me gusta" }}
    </p>
    @endif
</div>