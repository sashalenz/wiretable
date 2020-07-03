<div class="flex flex-col break-words bg-white border border-2 rounded shadow-md w-full" x-data="{ filtersAreShown: {{ is_null($this->filter) ? 'false' : 'true' }} }">
    <div class="flex justify-between bg-gray-200 text-gray-700 py-3 px-6">
        <div class="flex uppercase font-semibold align-center items-center">
            <div wire:offline>[OFFLINE]</div>
            {{ $this->title }}
            <span wire:loading><i class="far fa-sync fa-spin ml-2"></i></span>
        </div>
        <div class="content-center">
            @if(!$this->disableSearch)
                <input wire:model="search" class="px-4 py-2 rounded mr-4" type="text" placeholder="{{ __('Search') }}" size="30">
            @endif
            @if(count($this->filters))
                <span class="mr-4 cursor-pointer text-gray-500 relative" @click="filtersAreShown = !filtersAreShown">
                    <i class="far fa-filter"></i>
                </span>
            @endif
            <span class="mr-4 cursor-pointer text-gray-500 relative" wire:click="resetTable">
                <i class="far fa-eraser"></i>
            </span>
            <span class="mr-4 cursor-pointer text-gray-500 relative" wire:click="refresh">
                <i class="far fa-sync"></i>
            </span>
        </div>
    </div>
    <div
            class="flex justify-between bg-gray-200 text-gray-700"
            x-show="filtersAreShown"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-end="opacity-0"
    >
        <div class="flex w-full py-3 px-6 border-t align-center items-center">
            @foreach($this->filters as $filter)
                <div class="w-1/4 px-2">
                    {!! $filter->renderIt() !!}
                </div>
            @endforeach
        </div>
    </div>
    <div class="w-full">
        <table class="table-auto w-full">
            <thead>
            <tr class="bg-gray-300 text-gray-700">
                @foreach($this->columns as $column)
                    <th class="border px-4 py-2" @if($column->getWidth()) style="width: {{ $column->getWidth() }}%;" @endif>
                        @if($column->isSortable())
                            <span wire:click="$set('sort', '{{ ($this->sort !== $column->getName()) ? $column->getName() : sprintf('-%s', $column->getName()) }}')" class="cursor-pointer flex justify-between">
                                @if($column->getIcon())
                                    <i class="far {{ $column->getIcon() }}"></i>
                                @else
                                    {!! $column->getTitle() !!}
                                @endif
                                @if(!$column->isCurrentSort($this->sort))
                                    <i class="fad fa-sort"></i>
                                @else
                                    @if($column->isCurrentSort($this->sort, false))
                                        <i class="fad fa-sort-up"></i>
                                    @else
                                        <i class="fad fa-sort-down"></i>
                                    @endif
                                @endunless
                            </span>
                        @else
                            @if($column->getIcon())
                                <i class="far {{ $column->getIcon() }}"></i>
                            @else
                                {!! $column->getTitle() !!}
                            @endif
                        @endif
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @if($this->data->total())
                @foreach($this->data->items() as $row)
                    <tr class="even:bg-gray-100">
                        @foreach($this->columns as $column)
                            <td class="border px-4 py-2 {{ $column->getClass($row) }}">
                                {!! $column->renderIt($row) !!}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            @else
                @include('partials.empty-table')
            @endif
            </tbody>
        </table>
    </div>
    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
        @if($this->data !== null)
            <div class="flex flex-col sm:flex-row items-center justify-center">
{{--                <div class="flex content-center text-gray-500 items-center">--}}
{{--                    {{ __('Showing') }} {{ $this->data->firstItem() ?? 0 }} {{ __('to') }} {{ $this->data->lastItem() }} {{ __('from') }} {{ $this->data->total() }}--}}
{{--                </div>--}}
                <div class="flex">
                    {{ $this->data->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
