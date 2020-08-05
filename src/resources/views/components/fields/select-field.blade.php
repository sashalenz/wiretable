<div @if(isset($attributes)){{ $attributes->merge(['class' => "col-span-6 md:col-span-{$size} space-y-1"]) }}@else class="{{ $class }}" @endif>
    <div class="flex justify-between">
        <label for="{{ $name }}" class="block text-sm font-medium leading-5 text-gray-700">{{ $title ?? $name }}</label>
        @if($required)<span class="text-sm leading-5 text-gray-500" id="email-optional">@lang('wiretable::form.required')</span>@endif
    </div>
    <select id="{{ $name }}" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 @error($name)pr-10 border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" @if($placeholder)placeholder="{{ $placeholder }}"@endif name="{{ $name }}" aria-describedby="{{ $help }}" @if($required)required @endif wire:model="{{ $name }}">
        @foreach($options as $key => $option)
            <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
    @enderror
    @isset($help)
        <p class="mt-2 text-sm text-gray-500" id="email-description">{{ $help }}</p>
    @endif
</div>
