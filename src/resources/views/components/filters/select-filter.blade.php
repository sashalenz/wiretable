<div class="flex flex-wrap">
    <select id="{{ $name }}" class="form-input w-full @error($name) border-red-500 @enderror" name="{{ $name }}" wire:change="addFilter('{{ $name }}', $event.target.value)" @if($required) required @endif>
        @if(!$required)
            <option value="" class="text-gray-700" @if(is_null($value)) selected @endif>{{ $label }}</option>
        @endif
        @foreach($options as $key => $option)
            <option value="{{ $key }}" @if((int)$value === (int)$key) selected @endif>{{ $option }}</option>
        @endforeach
    </select>

    @error($name)
    <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
    </p>
    @enderror
</div>
