<div class="flex px-2" x-data="{{ json_encode(compact('name', 'label', 'value'), JSON_THROW_ON_ERROR) }}" x-init="$watch('value', value => @this.call('addFilter', name, value))">
    <label :for="name" class="flex justify-between cursor-pointer w-full">
        <span class="text-gray-700 font-medium" x-text="label || name"></span>
        <span class="relative ml-3">
            <input :id="name" type="checkbox" class="hidden" x-model="value" />
            <div class="toggle__line w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
            <div class="toggle__dot absolute w-6 h-6 bg-white rounded-full shadow inset-y-0 left-0"></div>
        </span>
    </label>
</div>
