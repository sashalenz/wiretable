<?php

namespace Sashalenz\Wiretable\Components\Fields;

use Illuminate\View\View;

class SelectField extends Field
{
    public array $options = [];

    public function options(array $options): self
    {
        $this->options = $options;

        return $this;
    }


    public function render(): View
    {
        return view('wiretable::components.fields.select-field')->with([
            'options' => $this->options
        ]);
    }
}
