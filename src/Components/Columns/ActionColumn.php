<?php

namespace Sashalenz\Wiretable\Components\Columns;

use Illuminate\View\View;

class ActionColumn extends Column
{
    private ?int $width = 5;
    private ?array $buttons = [];

    /**
     * @param array $buttons
     * @return $this
     */
    public function withButtons(array $buttons = []): self
    {
        $this->buttons = $buttons;
        return $this;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|string
     */
    public function render()
    {
        return view('wiretable::components.columns.action-column', [
            'buttons' => $this->buttons
        ]);
    }
}
