<x-wiretable-layout-field :name="$name"
                          :title="$title"
                          :size="$size"
                          :help="$help"
                          :required="$required"
                          :required-icon="$requiredIcon"
                          class="{{ $attributes->whereStartsWith('class')->first() }}"
>
    <div class="relative rounded-md shadow-sm">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                @svg($icon, 'h-5 w-5 text-gray-400')
            </div>
        @endif
        <input type="{{ $type }}"
               id="{{ $name }}"
               name="{{ $name }}"
               placeholder="{{ $placeholder }}"
               aria-describedby="{{ $help }}"
               class="form-input block w-full sm:text-sm sm:leading-5 @isset($icon) pl-10 @endisset @if($errors->has($name)) pr-10 border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @endif"
               @if($required)required="required" @endif
               @if(isset($attributes) && $attributes->whereStartsWith('wire:model')->first())
               wire:model="{{ $attributes->whereStartsWith('wire:model')->first() }}"
               @elseif(isset($attributes) && $attributes->whereStartsWith('wire:change')->first())
               wire:change="{{ $attributes->whereStartsWith('wire:change')->first() }}('{{ $name }}', $event.target.value)"
               @else
               wire:model="{{ $name }}"
                @endif
        >
        @error($name)
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        </div>
        @enderror
    </div>
</x-wiretable-layout-field>
