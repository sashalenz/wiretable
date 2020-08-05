<div x-data="window.customSelect({open: false, value: null, selected: null, options: [@foreach($options as $key => $option) {{ $key }}: '{{ $option }}'{{ !$loop->last ? ',' : '' }} @endforeach]})"
     x-init="init"
     @if(isset($attributes)){{ $attributes->merge(['class' => "col-span-{$size} space-y-1"]) }}@else class="{{ $class }}" @endif
>
    <label id="listbox-label" class="block text-sm leading-5 font-medium text-gray-700">
        {{ $title ?? $name }}
    </label>
    <div class="relative">
        <span class="inline-block w-full rounded-md shadow-sm">
            <button x-ref="button"
                    @keydown.arrow-up.stop.prevent="onButtonClick()"
                    @keydown.arrow-down.stop.prevent="onButtonClick()"
                    @click="onButtonClick()"
                    type="button"
                    aria-haspopup="listbox"
                    :aria-expanded="open"
                    aria-labelledby="listbox-label"
                    class="cursor-default relative w-full rounded-md border border-gray-300 bg-white pl-3 pr-10 py-2 text-left focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition ease-in-out duration-150 sm:text-sm sm:leading-5"
            >
                <span x-text="options[value]" class="block truncate"></span>
                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>
            </button>
        </span>

        <template x-if="options.length">
            <div x-show="open"
                 @click.away="open = false"
                 x-description="Select popover, show/hide based on select state."
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute mt-1 w-full rounded-md bg-white shadow-lg"
                 style="display: none;"
            >
                <ul @keydown.enter.stop.prevent="onOptionSelect()"
                    @keydown.space.stop.prevent="onOptionSelect()"
                    @keydown.escape="onEscape()"
                    @keydown.arrow-up.prevent="onArrowUp()"
                    @keydown.arrow-down.prevent="onArrowDown()"
                    x-ref="listbox"
                    tabindex="-1"
                    role="listbox"
                    aria-labelledby="listbox-label"
                    :aria-activedescendant="activeDescendant"
                    class="max-h-60 rounded-md py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5"
                    x-max="1"
                    aria-activedescendant=""
                >
                    <li x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                        x-for="(value, key) in options" :key="key"
                        x-state:on="Highlighted"
                        x-state:off="Not Highlighted"
                        :id="'listbox-option-'+key"
                        role="option"
                        @click="choose(key)"
                        @mouseenter="selected = key"
                        @mouseleave="selected = null"
                        :class="{ 'text-white bg-indigo-600': selected === key, 'text-gray-900': !(selected === key) }"
                        class="cursor-default select-none relative py-2 pl-3 pr-9 text-gray-900"
                    >
                    <span x-state:on="Selected"
                          x-state:off="Not Selected"
                          :class="{ 'font-semibold': value === key, 'font-normal': !(value === key) }"
                          class="font-normal block truncate"
                          x-text="value"
                    />
                        <span x-show="value === key"
                              x-description="Checkmark, only display for selected option."
                              x-state:on="Highlighted"
                              x-state:off="Not Highlighted"
                              :class="{ 'text-white': selected === key, 'text-indigo-600': !(selected === 0) }"
                              class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600"
                              style="display: none;"
                        >
                        <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M5 13l4 4L19 7"></path>
                        </svg>
                    </span>
                    </li>
                </ul>
            </div>
        </template>
    </div>
</div>
