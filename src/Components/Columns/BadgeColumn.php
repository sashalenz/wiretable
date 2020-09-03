<?php

namespace Sashalenz\Wiretable\Components\Columns;

use Illuminate\View\View;

class BadgeColumn extends Column
{
    /**
     * @return \Illuminate\Contracts\View\Factory|View|string
     */
    public function render()
    {
        return view('wiretable::components.columns.badge-column');
    }
}
