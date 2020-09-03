<?php

namespace Sashalenz\Wiretable\Components\Filters;

use Illuminate\View\View;
use Sashalenz\Wiretable\Components\Fields\SelectField;

class SelectFilter extends Filter
{
    public array $options = [];

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    public function castValue(string $value):? string
    {
        return ($value) ?: null;
    }

    public function renderIt(): View
    {
        return SelectField::make($this->name, $this->title)
            ->setSize($this->size)
            ->setPlaceholder($this->placeholder)
            ->setValue($this->value)
            ->setOptions($this->options)
            ->withAttributes([
                "wire:change" => "addFilter"
            ])
            ->renderIt();
    }
}
