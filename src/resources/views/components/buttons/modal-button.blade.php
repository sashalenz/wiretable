<button
        x-data="{ url: '{{ $route }}' }"
        class="text-gray-500 hover:text-blue-900 p-2 rounded text-lg {{ $class }}"
        @click.prevent="$dispatch('open-modal', url)"
>
    @if($icon)<i class="{{ $icon }}"></i>@endif
    {{ $title }}
</button>
