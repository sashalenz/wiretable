<a class="p-2 group flex items-center text-sm justify-center text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-100 transition ease-in-out duration-150 {{ $class }}"
   href="#"
   wire:click.prevent="restore({{ $row->id }})"
   rel="button"
>
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transform rotate-180">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
    </svg>
    @if($title)<span class="ml-3">{{ $title }}</span>@endif
</a>
