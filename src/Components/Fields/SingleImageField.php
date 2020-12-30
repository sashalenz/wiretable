<?php

namespace Sashalenz\Wiretable\Components\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class SingleImageField extends Field
{
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Support\Htmlable|\Closure|string|\Illuminate\Contracts\Foundation\Application
    {
        return view('wiretable::components.fields.single-image-field');
    }

    public function renderIt(?Model $model = null): \Illuminate\Contracts\Support\Htmlable|\Illuminate\Contracts\View\View|View|string|null
    {
        $condition = is_callable($this->displayCondition) ? call_user_func($this->displayCondition, $model) : true;

        if ((bool) $condition === false) {
            return null;
        }

        if(!is_null($model)) {
            $this->setValue($model->getFirstMediaUrl($this->name));
        }

        return $this->render()->with($this->data());
    }

}
