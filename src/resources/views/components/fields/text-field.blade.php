<div {{ $attributes->merge(['class' => "col-span-{$size}"]) }}>
    <div class="flex justify-between">
        <label for="{{ $name }}" class="block text-sm font-medium leading-5 text-gray-700">{{ $title ?? $name }}</label>
        @if($required)<span class="text-sm leading-5 text-gray-500" id="email-optional">@lang('wiretable::form.required')</span>@endif
    </div>
    <div class="mt-1 relative rounded-md shadow-sm">
        @isset($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                @svg($icon, 'h-5 w-5 text-gray-400')
            </div>
        @endisset
        <input type="{{ $type }}" id="{{ $name }}" class="form-input block w-full sm:text-sm sm:leading-5 @isset($icon)pl-10 @endisset @error($name)pr-10 border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" @if($placeholder)placeholder="{{ $placeholder }}" @endif name="{{ $name }}" aria-describedby="{{ $help }}" @if($required)required @endif wire:model="{{ $name }}">
        @error($name)
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        </div>
        @enderror
    </div>
    @error($name)
    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
    @enderror
    @isset($help)
        <p class="mt-2 text-sm text-gray-500" id="email-description">{{ $help }}</p>
    @endif
</div>
