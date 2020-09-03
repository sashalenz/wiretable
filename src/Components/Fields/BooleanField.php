<?php

namespace Sashalenz\Wiretable\Components\Fields;

use Illuminate\View\View;

class BooleanField extends Field
{
    public function castValue($value)
    {
        return (bool) $value;
    }

    public function render(): View
    {
        return view('wiretable::components.fields.boolean-field');
    }
}
