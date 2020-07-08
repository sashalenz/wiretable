<?php

namespace Sashalenz\Wiretable\Components\Filters;

use Illuminate\View\View;

class SelectFilter extends Filter
{
    public function castValue(string $value):? string
    {
        return ($value) ?: null;
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('wiretable::components.filters.select-filter');
    }
}
