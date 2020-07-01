<?php

namespace Sashalenz\Wiretable\Components\Buttons;

class ShowButton extends Button
{
    protected ?string $icon = 'far fa-eye';

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('wiretable::components.buttons.base-button');
    }
}
