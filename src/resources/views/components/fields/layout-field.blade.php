<div
        @if(isset($attributes) && $attributes->whereStartsWith('class')->first())
        {{ $attributes->whereStartsWith('class')->merge(['class' => "col-span-6 md:col-span-{$size}"]) }}
        @else
        class="col-span-6 md:col-span-{{ $size }} {{ $class ?? '' }}"
        @endif
>
    <div class="mb-1 flex justify-between">
        <label for="{{ $name }}" class="block text-sm font-medium leading-5 text-gray-700">{{ $title }}</label>
        @if($required && $requiredIcon)
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="lightning-bolt w-5 h-5 text-gray-300">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        @endif
    </div>
    {{ $slot }}
    @error($name)
        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
    @enderror
    @isset($help)
        <div class="mt-2 text-sm text-gray-500">{{ $help }}</div>
    @endisset
</div>
