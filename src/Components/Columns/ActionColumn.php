<?php

namespace Sashalenz\Wiretable\Components\Columns;

use Illuminate\Support\Collection;
use Illuminate\View\View;

class ActionColumn extends Column
{
    private ?int $width = 5;
    private ?Collection $buttons;

    /**
     * @param Collection $buttons
     * @return $this
     */
    public function withButtons(Collection $buttons): self
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
                ->reject(fn ($button) => is_null($button))
        ]);
    }
}
