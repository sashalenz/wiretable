<?php

namespace Sashalenz\Wiretable\Components\Filters;

use Illuminate\View\View;
use Spatie\QueryBuilder\AllowedFilter;

abstract class Filter extends AllowedFilter
{
    protected int $size = 6;
    protected ?string $title = null;
    protected ?string $placeholder = null;
    protected ?string $value = null;

    /**
     * @param string $title
     * @return $this
     */
    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $placeholder
     * @return $this
     */
    public function placeholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function size(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function value(?string $value = null): self
    {
        $this->value = $value;
        return $this;
    }

    protected function getValue(?string $value = null)
    {
        $newValue = method_exists($this, 'castValue') ? $this->castValue($value) : $value;
        return ($newValue !== $this->getDefault()) ? $newValue : null;
    }

    abstract public function renderIt(): View;
}
