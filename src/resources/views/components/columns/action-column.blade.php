<div class="whitespace-no-wrap">
    @foreach($buttons as $button)
        {!! $button->renderIt($row) !!}
    @endforeach
</div>
