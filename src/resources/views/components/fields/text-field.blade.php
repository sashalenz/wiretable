<div x-data="{name: '{{ $name }}', value: '{{ $value }}', type: '{{ $type }}', hasError: {{ (int) $hasError }}, placeholder: '{{ $placeholder }}', help: '{{ $help }}', required: {{ (int) $required }}}"
@if(isset($attributes) && $attributes->whereStartsWith('class')->first()){{ $attributes->whereStartsWith('class')->merge(['class' => "col-span-6 md:col-span-{$size}"]) }}@endif
>
    <div class="flex justify-between">
        <label :for="name" class="block text-sm font-medium leading-5 text-gray-700">{{ $title }}</label>
        <span class="text-sm leading-5 text-gray-500" x-show="required" x-cloak>@lang('wiretable::form.required')</span>
    </div>
    <div class="mt-1 relative rounded-md shadow-sm">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" x-show="icon">
                @svg($icon, 'h-5 w-5 text-gray-400')
            </div>
        @endif
        <input :type="type"
               :id="name"
               :name="name"
               :value="value"
               :placeholder="placeholder"
               :aria-describedby="help"
               class="form-input block w-full sm:text-sm sm:leading-5 @isset($icon) pl-10 @endisset"
               x-bind:class="{ 'pr-10 border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red': hasError }"
               x-bind:required="required"
               @if(isset($attributes) && $attributes->whereStartsWith('wire:model')->first())
               wire:model="{{ $attributes->whereStartsWith('wire:model')->first() }}"
               @else
               wire:model="name"
               @endif
        >
        @include('wiretable::partials.error-icon')
    </div>
    @include('wiretable::partials.error-text')
    <p class="mt-2 text-sm text-gray-500" x-show="help" x-html="help" />
</div>
