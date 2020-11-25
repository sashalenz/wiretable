@section('title', $this->title)

<form id="form" wire:submit.prevent="save">
    <x-wiretable-form></x-wiretable-form>
</form>

@push('buttons')
    <button type="submit" form="form" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
        @lang('buttons.create')
    </button>
@endpush
