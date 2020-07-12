<?php

namespace Sashalenz\Wiretable\Components\Buttons;

abstract class ModalButton extends Button
{
    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('wiretable::components.buttons.modal-button');
    }
}
