<span wire:click="$set('sort', '{{ ($sort !== $name) ? $name : sprintf('-%s', $name) }}')" class="cursor-pointer flex justify-between">
    @if($icon)
        <i class="far {{ $icon }}"></i>
    @else
        {!! $title !!}
    @endif
    @unless($isCurrentSort)
        <i class="fad fa-sort"></i>
    @else
        @if($isSortUp)
            <i class="fad fa-sort-up"></i>
        @else
            <i class="fad fa-sort-down"></i>
        @endif
    @endunless
</span>
