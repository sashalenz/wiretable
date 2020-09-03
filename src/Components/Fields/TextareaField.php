<?php

namespace Sashalenz\Wiretable\Components\Fields;

use Illuminate\View\View;

class TextareaField extends Field
{
    public int $rows = 3;

    public function __construct(string $name, ?string $title = null, $value = null, ?bool $required = false, ?string $placeholder = null, ?string $default = null, ?string $help = null, ?int $size = 6, ?int $rows = 3)
    {
        $this->rows = $rows;
        parent::__construct($name, $title, $value, $required, $placeholder, $default, $help, $size);
    }

    /**
     * @param int $rows
     * @return $this
     */
    public function setRows(int $rows): self
    {
        $this->rows = $rows;
        return $this;
    }

    public function render(): View
    {
        return view('wiretable::components.fields.textarea-field');
    }
}
