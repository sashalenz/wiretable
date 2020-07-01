<a
        class="text-gray-500 hover:text-blue-900 p-2 rounded text-lg {{ $class }}"
        @if($route) href="{{ $route }}" @endif
        rel="button"
>
        @if($icon)<i class="{{ $icon }}"></i>@endif
        {{ $title }}
</a>
