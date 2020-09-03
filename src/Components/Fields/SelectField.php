<?php

namespace Sashalenz\Wiretable\Components\Fields;

use Illuminate\View\View;

class SelectField extends Field
{
    public array $options = [];
    public bool $nullable = false;

    public function __construct(string $name, ?string $title = null, $value = null, ?bool $required = false, ?string $placeholder = null, ?string $default = null, ?string $help = null, ?int $size = 6, array $options = [], bool $nullable = false)
    {
        $this->options = $options;
        $this->nullable = $nullable;

        parent::__construct($name, $title, $value, $required, $placeholder, $default, $help, $size);
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function isNullable(): self
    {
        $this->nullable = true;

        return $this;
    }

    public function render(): View
    {
        return view('wiretable::components.fields.select-field');
    }
}
