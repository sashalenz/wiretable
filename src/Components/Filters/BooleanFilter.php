<?php

namespace Sashalenz\Wiretable\Components\Filters;

use Illuminate\View\View;
use Sashalenz\Wiretable\Components\Fields\BooleanField;

class BooleanFilter extends Filter
{
    /**
     * @param string|null $value
     * @return string|null
     */
    public function getValue(?string $value = null): ?string
    {
        if (!$this->hasDefault()) {
            return (bool) $value === true ?: null;
        }

        return ((bool) $value !== $this->getDefault()) ? (bool) $value : null;
    }

    /**
     * @return View
     */
    public function renderIt(): View
    {
        return BooleanField::make($this->name, $this->title)
            ->setSize($this->size)
            ->setValue($this->value)
            ->setDefault($this->getDefault() ?? false)
            ->withAttributes([
                "wire:change" => "addFilter"
            ])
            ->renderIt();
    }
}
