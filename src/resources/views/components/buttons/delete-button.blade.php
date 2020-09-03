<a class="p-2 group flex items-center text-sm justify-center text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-100 transition ease-in-out duration-150 {{ $class }}"
   href="#"
   wire:click.prevent="delete({{ $row->id }})"
   rel="button"
>
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
    </svg>
    @if($title)<span class="ml-3">{{ $title }}</span>@endif
</a>
