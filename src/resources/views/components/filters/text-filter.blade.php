<div class="flex flex-wrap">
    <label for="{{ $name }}" class="block text-gray-700 text-sm font-bold mb-2">
        {{ $label ?? $name }}:
    </label>

    <input id="{{ $name }}" type="{{ $type }}" class="form-input w-full @error($name) border-red-500 @enderror" name="{{ $name }}" value="{{ old($name) }}" @if($required) required @endif>

    @error($name)
    <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
    </p>
    @enderror
</div>
