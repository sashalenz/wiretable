<div class="flex flex-col break-words bg-white border rounded shadow-md w-full" x-data="{ filtersCount: {{ count($this->filters) }}, filtersAreShown: {{ is_null($this->filter) ? 'false' : 'true' }} }">
    <div class="flex flex-col sm:flex-row justify-between bg-gray-200 text-gray-700 py-3 px-2 sm:px-6">
        <div class="flex uppercase font-semibold align-center items-center mb-2 sm:mb-0 py-2">
            <div wire:offline>[OFFLINE]</div>
            {{ $this->title }}
            <span wire:loading><i class="far fa-sync fa-spin ml-2"></i></span>
        </div>
        <div class="content-center flex items-center">
            <div class="w-full">
                @if(!$this->disableSearch)
                    <input wire:model="search" class="px-4 py-2 rounded mr-4" type="text" placeholder="{{ __('Search') }}" size="20">
                @endif
            </div>
            <span class="mr-4 cursor-pointer text-gray-500 relative" x-show="filtersCount" @click="filtersAreShown = !filtersAreShown">
                    <i class="far fa-filter"></i>
                </span>
            <span class="mr-4 cursor-pointer text-gray-500 relative" wire:click="resetTable">
                <i class="far fa-eraser"></i>
            </span>
            <span class="cursor-pointer text-gray-500 relative" wire:click="refresh">
                <i class="far fa-sync"></i>
            </span>
        </div>
    </div>
    <div
            class="flex justify-between bg-gray-200 text-gray-700"
            x-show.transition.opacity="filtersCount && filtersAreShown"
            x-cloak
    >
        <div class="flex w-full py-3 px-6 border-t align-center items-center">
            @foreach($this->filters as $filter)
                <div class="w-full sm:w-1/2 lg:w-1/4 px-2">
                    {!! $filter->renderIt() !!}
                </div>
            @endforeach
        </div>
    </div>
    <div
            x-data="window.toggleHandler()"
            class="flex justify-between bg-gray-200 text-gray-700"
            x-show.transition.opacity="checked.length"
            @toggle-check.window="toggleCheck($event.detail)"
            x-cloak
    >
        <div class="flex w-full py-3 px-6 border-t align-center items-center">
            @foreach($this->actions as $action)
                <div class="w-full sm:w-1/2 lg:w-1/4 px-2">
                    @livewire($action->getName(), ['model' => $action->getModel(), 'icon' => $action->getIcon(), 'title' => $action->getTitle()], key($loop->index))
                </div>
            @endforeach
        </div>
    </div>
    <div class="w-full overflow-hidden lg:overflow-visible">
        <div class="w-full overflow-x-scroll overflow-y-visible lg:overflow-visible">
            <table class="w-full">
                <thead>
                <tr class="bg-gray-300 text-gray-700">
                    @foreach($this->columns as $column)
                        <th class="border px-4 py-2 whitespace-no-wrap" @if($column->getWidth()) style="width: {{ $column->getWidth() }}%;" @endif>
                            {!! $column->renderTitle($this->sort) !!}
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @if(count($this->data->items()))
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
    </div>
    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
        @if($this->data !== null)
            <div class="flex flex-col sm:flex-row items-center justify-between">
                <div class="flex content-center text-gray-500 items-center">
                    {{ __('Showing') }} {{ $this->data->firstItem() ?? 0 }} {{ __('to') }} {{ $this->data->lastItem() }} {{ __('from') }} {{ $this->data->total() }}
                </div>
                <div class="flex">
                    {{ $this->data->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<script type="application/javascript" src="{{ asset('vendor/wiretable/app.js') }}"></script>
