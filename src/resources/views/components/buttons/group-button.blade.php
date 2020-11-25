<div x-data="{ open: false }" @keydown.escape="open = false" @click.away="open = false" class="relative">
    <button aria-has-popup="true"
            :aria-expanded="open"
            type="button"
            @click="open = !open"
            class="p-2 group flex items-center justify-center text-gray-400 rounded-full bg-transparent hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-100 transition ease-in-out duration-150"
            aria-expanded="true"
    >
        @if($icon)@svg($icon, 'h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500')@endif
        @if($title)<span class="ml-3">{{ $title }}</span>@endif
    </button>
    <div x-show="open"
         x-cloak
         x-description="Dropdown panel, show/hide based on dropdown state."
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="mx-3 origin-top-right absolute z-20 right-7 top-0 w-48 mt-1 rounded-md shadow-lg"
    >
        <div class="rounded-md bg-white ring-1 ring-black ring-opacity-5 space-y-2" role="menu" aria-orientation="vertical" aria-labelledby="project-options-menu-10">
            @foreach($buttons as $button)
                <div class="hover:bg-gray-100 focus:bg-gray-100">
                    {!! $button->renderIt($row) !!}
                </div>
            @endforeach
        </div>
    </div>
</div>
