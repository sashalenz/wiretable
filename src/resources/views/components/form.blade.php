<div class="w-full mt-6">
    <div class="grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
        @foreach($this->fields as $field)
            {!! $field->renderIt($this->modelClass) !!}
        @endforeach
    </div>
</div>
