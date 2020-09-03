<?php

namespace Sashalenz\Wiretable\Components\Buttons;

final class RestoreButton extends Button
{
    protected ?string $icon = 'save';
    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('wiretable::components.buttons.restore-button');
    }
}
