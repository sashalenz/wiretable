<?php

namespace Sashalenz\Wiretable\Components\Buttons;

final class DeleteButton extends Button
{
    protected ?string $icon = 'trash';
    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('wiretable::components.buttons.delete-button');
    }
}
