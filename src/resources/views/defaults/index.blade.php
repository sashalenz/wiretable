@if($this->createButton)
    @push('actions')
        <button
                type="button"
                class="inline-flex items-center md:px-4 p-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:ring-primary-500 focus:border-primary-500 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out"
                x-data="{ url: '{{ route($this->createButton) }}' }"
                @click.prevent="$dispatch('open-modal', url)"
        >
            <x-heroicon-o-plus class="w-4 h-4" />
            <span class="hidden md:inline-block ml-2">@lang('buttons.add')</span>
        </button>
    @endpush
@endif

<div>
    <x-wiretable-table></x-wiretable-table>
</div>
