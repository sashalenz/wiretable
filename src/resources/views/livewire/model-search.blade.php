<div class="w-full relative" x-on:click.away="@this.set('isOpen', false)">
    <div class="cursor-pointer form-input" x-on:click.prevent="@this.set('isOpen', true)">
        <div class="relative" role="textbox">
            @if($this->selected)
                @unless($required)
                    <span class="absolute right-0 top-0 z-20" title="Remove all items" wire:click="setSelected(null)">×</span>
                @endif
                {{ $this->selected->getDisplayName() }}
            @else
                {{ $label ?? __('Please select') }}
            @endif
        </div>
    </div>
    @if($isOpen)
        <div class="absolute top-auto inset-x-0 border bg-gray-200 w-full">
            <div class="p-2 relative">
                <input type="search" wire:model.debounce.500ms="search" class="form-input p-1 w-full">
                <div class="absolute top-0 right-0 p-2" wire:loading wire:target="search">
                    <i class="far fa-spinner"></i>
                </div>
            </div>
            <ul class="list-none max-h-64 overflow-y-scroll" style="max-height: 200px;" role="listbox" aria-expanded="true" aria-hidden="false">
                @if($this->results->count())
                    @foreach($this->results as $item)
                        <li class="border-b hover:bg-gray-500 p-2 cursor-pointer" role="option" @if($item->id === $value) aria-selected="true" @endif wire:click="setSelected({{ $item->{$item->getKeyName()} }})">{{ $item->getDisplayName() }}</li>
                    @endforeach
                @else
                    <li class="text-gray-700 p-2">{{ __('Results not found') }}</li>
                @endif
            </ul>
        </div>
    @endif
</div>
