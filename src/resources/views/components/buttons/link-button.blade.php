<a class="px-2 group flex items-center text-sm justify-center text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-100 transition ease-in-out duration-150 {{ $class }}"
   @if($route)href="{{ $route }}" @endif
   @if($target)target="{{ $target }}" @endif
   rel="button"
>
   @if($icon)@svg($icon, 'h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500')@endif
   @if($title)<span class="ml-3">{{ $title }}</span>@endif
</a>
