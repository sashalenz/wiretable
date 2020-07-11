<?php

namespace Sashalenz\Wiretable\Components\Actions;

class LivewireAction extends Action
{
    public function getName(): string
    {
        return sprintf('actions.%s', parent::getName());
    }
}
