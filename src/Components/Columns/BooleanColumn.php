<?php

namespace Sashalenz\Wiretable\Components\Columns;

use Illuminate\View\View;

class BooleanColumn extends Column
{
    /**
     * @return \Illuminate\Contracts\View\Factory|View|string
     */
    public function render()
    {
        return view('wiretable::components.columns.boolean-column');
    }
}
