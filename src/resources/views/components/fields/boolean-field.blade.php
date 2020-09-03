<div
        @if(isset($attributes) && $attributes->whereStartsWith('class')->first())
        {{ $attributes->whereStartsWith('class')->merge(['class' => "col-span-6 md:col-span-{$size}"]) }}
        @else
        class="col-span-6 md:col-span-{{ $size }} {{ $class ?? '' }}"
        @endif
>
    <div class="flex items-center my-2">
        <label for="{{ $name }}"
               class="flex items-center cursor-pointer"
               @if(isset($this->{$name}))
               x-data="{ on: {{ $this->{$name} ? 'true' : 'false' }} }"
               @else
               x-data="{ on: {{ $value ? 'true' : 'false' }} }"
               @endif
               :aria-checked="on.toString()"
               @focus="focused = true"
               @blur="focused = false"
        >
            <div class="group relative inline-flex items-center justify-center flex-shrink-0 h-5 w-10 cursor-pointer focus:outline-none">
                <input id="{{ $name }}"
                       name="{{ $name }}"
                       class="hidden"
                       type="checkbox"
                       @if(isset($attributes) && $attributes->whereStartsWith('wire:model')->first())
                       wire:model="{{ $attributes->whereStartsWith('wire:model')->first() }}"
                       @elseif(isset($attributes) && $attributes->whereStartsWith('wire:change')->first())
                       wire:change="{{ $attributes->whereStartsWith('wire:change')->first() }}('{{ $name }}', $event.target.checked)"
                       @else
                       wire:model="{{ $name }}"
                       @endif
                       @change="on = $event.target.checked"
                >
                <div class="absolute h-4 w-9 mx-auto rounded-full transition-colors ease-in-out duration-200 bg-gray-200"
                     :class="{ 'bg-indigo-600': on, 'bg-gray-200': !on }"
                ></div>
                <div class="absolute left-0 inline-block h-5 w-5 border border-gray-200 rounded-full bg-white shadow transform group-focus:shadow-outline group-focus:border-blue-300 transition-transform ease-in-out duration-200 translate-x-0"
                     :class="{ 'translate-x-5': on, 'translate-x-0': !on }"></div>
            </div>
            <div class="ml-3 block text-sm leading-5 font-medium text-gray-700">
                {{ $title }}
                @isset($help)
                    <div class="font-light text-xs text-gray-400">{{ $help }}</div>
                @endisset
            </div>
        </label>
    </div>
    @error($name)
    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
    @enderror
</div>
