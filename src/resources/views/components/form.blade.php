<div class="w-full mt-6">
    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
        @foreach($this->fields as $field)
            {!! $field->renderIt($this->modelClass) !!}
        @endforeach
    </div>
</div>
