<?php

namespace Sashalenz\Wiretable\Components\Columns;

use Illuminate\View\View;

class CheckboxColumn extends Column
{
    protected ?int $width = 2;

    public function renderTitle(?string $sort = null)
    {
        return view('wiretable::partials.checkbox-title');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|string
     */
    public function render()
    {
        return view('wiretable::components.columns.checkbox-column');
    }
}
