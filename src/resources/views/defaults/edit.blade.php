@section('title', $this->title)

<form id="form" wire:submit.prevent="save">
    <x-wiretable-form></x-wiretable-form>
</form>

@push('buttons')
    <span class="ml-3 inline-flex rounded-md shadow-sm">
        <button type="submit" form="form" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
            @lang('buttons.update')
        </button>
    </span>
@endpush
