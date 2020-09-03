<x-wiretable-layout-field :name="$name"
                          :title="$title"
                          :size="$size"
                          :help="$help"
                          :required="$required"
                          :required-icon="$requiredIcon"
                          class="{{ $attributes->whereStartsWith('class')->first() }}"
>
    <select id="{{ $name }}"
            name="{{ $name }}"
            aria-describedby="{{ $name }}"
            class="form-select block w-full sm:text-sm text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 @if($errors->has($name)) pr-10 border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @endif "
            @if($required) required="required" @endif
            @if(isset($attributes) && $attributes->whereStartsWith('wire:model')->first())
            wire:model="{{ $attributes->whereStartsWith('wire:model')->first() }}"
            @elseif(isset($attributes) && $attributes->whereStartsWith('wire:change')->first())
            wire:change="{{ $attributes->whereStartsWith('wire:change')->first() }}('{{ $name }}', $event.target.value)"
            @else
            wire:model="{{ $name }}"
            @endif
    >
        @if($nullable)
            <option value>{{ $placeholder ?? __('wiretable::form.please_select') }}</option>
        @endif
        @foreach($options as $key => $option)
            <option value="{{ $key }}"
                    @if((isset($this->{$name}) && (string) $this->name === (string) $key) || (string) $value === (string) $key) selected @endif
            >{{ $option }}</option>
        @endforeach
    </select>
</x-wiretable-layout-field>
