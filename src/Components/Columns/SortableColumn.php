<?php

namespace Sashalenz\Wiretable\Components\Columns;

class SortableColumn extends Column
{
    public function render()
    {
        return view('wiretable::components.columns.sortable-column');
    }
}
