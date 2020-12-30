<?php

namespace Sashalenz\Wiretable\Components\Fields;

use Illuminate\View\View;

class DateTimeField extends Field
{
    public function render()
    {
        return view('wiretable::components.fields.date-time-field');
    }
}
