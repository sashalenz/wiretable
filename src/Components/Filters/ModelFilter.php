<?php

namespace Sashalenz\Wiretable\Components\Filters;

use Illuminate\View\View;

class ModelFilter extends Filter
{
    public string $model;

    public function model($model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('wiretable::components.filters.model-filter', [
            'model' => $this->model
        ]);
    }
}
