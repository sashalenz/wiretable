<?php

namespace Sashalenz\Wiretable\Components\Filters;

use Illuminate\View\View;

class TextFilter extends Filter
{
    /**
     * @return View
     */
    public function render(): View
    {
        return view('wiretable::components.filters.text-input');
    }
}
