<?php

namespace Sashalenz\Wiretable\Components\Filters;

use Illuminate\View\View;

class SwitchFilter extends Filter
{
    public function castValue(string $value): bool
    {
        return (bool) $value;
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('wiretable::components.filters.switch-filter');
    }
}
