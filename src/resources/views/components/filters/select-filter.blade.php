<div class="flex px-2">
    <select id="{{ $name }}" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" name="{{ $name }}" wire:change="addFilter('{{ $name }}', $event.target.value)" @if($required) required @endif>
        @if(!$required)
            <option value="" @if(is_null($value)) selected @endif>{{ $label }}</option>
        @endif
        @foreach($options as $key => $option)
            <option value="{{ $key }}" @if((int)$value === (int)$key) selected @endif>{{ $option }}</option>
        @endforeach
    </select>
</div>
