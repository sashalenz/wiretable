<?php

namespace Sashalenz\Wiretable\Components\Fields;

use Illuminate\View\View;

class SelectField extends Field
{
    public array $options = [];

    public function __construct(string $name, ?string $title = null, ?string $icon = null, bool $required = false, ?string $placeholder = null, ?string $help = null, string $type = 'text', int $size = 6, array $options = [])
    {
        $this->options = $options;
        parent::__construct($name, $title, $icon, $required, $placeholder, $help, $type, $size);
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }


    public function render(): View
    {
        return view('wiretable::components.fields.select-field')
            ->with([
                'options' => $this->options
            ]);
    }
}
