<?php

namespace Sashalenz\Wiretable\Components\Filters;

use Illuminate\View\View;
use Sashalenz\Wiretable\Components\Fields\SelectField;

class TrashedFilter extends Filter
{
    /**
     * @return View
     */
    public function renderIt(): View
    {
        return SelectField::make($this->name, $this->title)
            ->setSize($this->size)
            ->setPlaceholder($this->placeholder)
            ->isRequired()
            ->hideRequiredIcon()
            ->setValue($this->value)
            ->setOptions([
                null => __('wiretable::form.without_trashed'),
                'with' => __('wiretable::form.with_trashed'),
                'only' => __('wiretable::form.only_trashed')
            ])
            ->withAttributes([
                "wire:change" => "addFilter"
            ])
            ->renderIt();
    }
}
