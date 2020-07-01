<?php

namespace Sashalenz\Wiretable\Components\Columns;

use Illuminate\View\View;

class TextColumn extends Column
{
    /**
     * @return View|null
     */
    public function render():? View
    {
        return null;
    }
}
