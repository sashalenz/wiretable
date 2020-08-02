<?php

namespace Sashalenz\Wiretable\Components\Fields;

use Illuminate\View\View;

class TextField extends Field
{
    public function render(): View
    {
        return view('wiretable::components.fields.text-field');
    }
}
