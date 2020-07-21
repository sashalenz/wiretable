<div class="flex px-2">
    <select id="{{ $name }}" class="form-input w-full" name="{{ $name }}" wire:change="addFilter('{{ $name }}', $event.target.value)" @if($required) required @endif>
        @if(!$required)
            <option value="" class="text-gray-700" @if(is_null($value)) selected @endif>{{ $label }}</option>
        @endif
        @foreach($options as $key => $option)
            <option value="{{ $key }}" @if((int)$value === (int)$key) selected @endif>{{ $option }}</option>
        @endforeach
    </select>
</div>
