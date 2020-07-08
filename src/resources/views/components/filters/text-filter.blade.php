<div class="flex flex-wrap">
    <label for="{{ $name }}" class="block text-gray-700 text-sm font-bold mb-2">
        {{ $label ?? $name }}:
    </label>

    <input id="{{ $name }}" type="{{ $type }}" class="form-input w-full" name="{{ $name }}" value="{{ old($name) }}" @if($required) required @endif>
</div>
