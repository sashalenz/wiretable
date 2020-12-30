<div x-data="{ delayed : 0 }" x-init="requestAnimationFrame(() => delayed = 1)">
    <template x-if="delayed">
        <div class="relative" x-data="{ open: @entangle('isOpen'), search: @entangle('search') }">
            <button type="button"
                    aria-haspopup="listbox"
                    aria-expanded="true"
                    aria-labelledby="listbox-label"
                    @if(!$readonly)x-on:click.prevent="open = !open" @endif
                    class="cursor-default relative w-full rounded-md border border-gray-300 pl-3 pr-10 py-2 text-left focus:outline-none @if($readonly) bg-gray-100 @else bg-white focus:ring-primary-500 focus:border-primary-500 focus:border-blue-300 @endif transition ease-in-out duration-150 sm:text-sm sm:leading-5"
            >
                @if($this->selected)
                    <span class="block truncate">{{ $this->selected->getDisplayName() }}</span>
                @else
                    <span class="block truncate text-gray-500">{{ ($placeholder ?? __('wiretable::form.please_select')) }}</span>
                @endif
                @if($required)
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                @elseif($this->selected)
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 cursor-pointer" x-on:click.prevent="$wire.call('setSelected', null)">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                @endif
            </button>
            @if(!$readonly)
                <div class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-20"
                     x-show="open"
                     x-on:click.away="open = false"
                     x-description="Select popover, show/hide based on select state."
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                >
                    <ul tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-item-3" class="max-h-60 rounded-md py-1 text-base leading-6 ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm sm:leading-5">
                        <div class="relative p-2">
                            <label class="sr-only" for="search">@lang('wiretable::form.search')</label>
                            <input id="search"
                                   type="text"
                                   class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full py-1 sm:text-sm border-gray-300 rounded-md"
                                   x-model="search"
                                   placeholder="@lang('wiretable::form.search')"
                            >
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg wire:loading="search" class="h-4 w-4 text-gray-400 animate" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                        </div>
                        @forelse($this->results as $item)
                            <li id="listbox-option-{{ $loop->index }}" role="option" class="group text-gray-900 focus:text-white focus:bg-primary-600 hover:text-white hover:bg-primary-600 cursor-default select-none relative py-2 pl-3 pr-9">
                                <span class="block truncate {{ $this->selected && $item->{$item->getKeyName()} === $this->selected->{$item->getKeyName()} ? 'font-semibold' : 'font-normal' }}"
                                      x-on:click.prevent="@this.call('setSelected', '{{ $item->{$item->getKeyName()} }}')"
                                >
                                    {{ $item->getDisplayName() }}
                                </span>
                                @if($this->selected && $item->{$item->getKeyName()} === $this->selected->{$item->getKeyName()})
                                    <span class="text-primary-600 group-focus:text-white group-hover:text-white absolute inset-y-0 right-0 flex items-center pr-4">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                @endif
                            </li>
                        @empty
                            <li id="listbox-option-null" role="option" class="group text-gray-500 cursor-default select-none relative py-2 pl-3 pr-9">
                            <span class="font-normal block truncate">
                                @lang('wiretable::form.results_not_found')
                            </span>
                            </li>
                        @endforelse
                    </ul>
                </div>
            @endif
        </div>
    </template>
</div>
