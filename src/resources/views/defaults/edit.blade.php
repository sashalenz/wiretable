@section('title', $this->title)

<form id="form" wire:submit.prevent="save">
    <x-wiretable-form></x-wiretable-form>
</form>

@push('buttons')
    <button type="submit" form="form" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-primary-600 hover:bg-primary-500 focus:outline-none focus:ring-primary-500 focus:border-primary-500 active:bg-primary-700 transition duration-150 ease-in-out">
        @lang('buttons.update')
    </button>
@endpush
