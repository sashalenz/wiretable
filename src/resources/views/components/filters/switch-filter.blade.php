<div class="flex flex-wrap">
    <label for="{{ $name }}" class="flex justify-between cursor-pointer w-full">
        <span class="text-gray-700 font-medium">
            {{ $label ?? $name }}
        </span>
        <span class="relative ml-3">
            <input id="{{ $name }}" type="checkbox" class="hidden" wire:click="addFilter('{{ $name }}', {{ ($value) ? '0' : '1' }})" value="{{ $value }}" @if($value) checked @endif />
            <div class="toggle__line w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
            <div class="toggle__dot absolute w-6 h-6 bg-white rounded-full shadow inset-y-0 left-0"></div>
        </span>
    </label>
    @error($name)
    <p class="text-red-500 text-xs italic mt-4">
        {{ $message }}
    </p>
    @enderror
</div>
