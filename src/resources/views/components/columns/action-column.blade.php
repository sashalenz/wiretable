<div class="relative flex justify-end items-center">
    @foreach($buttons as $button)
        {!! $button->title(null)->renderIt($row) !!}
    @endforeach
</div>
