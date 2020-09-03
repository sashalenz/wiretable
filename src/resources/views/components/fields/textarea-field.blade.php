<x-wiretable-layout-field :name="$name"
                          :title="$title"
                          :size="$size"
                          :help="$help"
                          :required="$required"
                          :required-icon="$requiredIcon"
                          class="{{ $attributes->whereStartsWith('class')->first() }}"
>
    <div class="relative rounded-md shadow-sm">
            <textarea id="{{ $name }}"
                      name="{{ $name }}"
                      placeholder="{{ $placeholder }}"
                      aria-describedby="{{ $name }}"
                      class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5  @if($errors->has($name)) border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @endif"
                      @if($required)required="required" @endif
                      @keyup="$dispatch('type', $event.target.value.length)"
                      @if(isset($attributes) && $attributes->whereStartsWith('wire:model')->first())
                      wire:model="{{ $attributes->whereStartsWith('wire:model')->first() }}"
                      @elseif(isset($attributes) && $attributes->whereStartsWith('wire:change')->first())
                      wire:change="{{ $attributes->whereStartsWith('wire:change')->first() }}('{{ $name }}', $event.target.value)"
                      @else
                      wire:model="{{ $name }}"
                      @endif
            ></textarea>
    </div>
</x-wiretable-layout-field>
