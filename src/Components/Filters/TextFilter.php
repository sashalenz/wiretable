<?php

namespace Sashalenz\Wiretable\Components\Filters;

use Illuminate\View\View;
use Sashalenz\Wiretable\Components\Fields\TextField;

class TextFilter extends Filter
{
    /**
     * @return View
     */
    public function renderIt(): View
    {
        return TextField::make($this->name, $this->title)
            ->setSize($this->size)
            ->setPlaceholder($this->placeholder)
            ->setValue($this->value)
            ->withAttributes([
                "wire:change" => "addFilter"
            ])
            ->renderIt();
    }
}
