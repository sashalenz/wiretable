<?php

namespace Sashalenz\Wiretable\Components\Columns;

use Illuminate\View\View;

class BelongsToColumn extends Column
{
    private ?string $icon = null;
    private ?string $route = null;

    /**
     * @param string|null $icon
     * @return $this
     */
    public function icon(?string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @param string|null $route
     * @return $this
     */
    public function route(?string $route): self
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('wiretable::components.columns.belongs-to-column')
            ->with([
                'icon' => $this->icon
            ]);
    }
}
