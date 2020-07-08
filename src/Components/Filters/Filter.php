<?php

namespace Sashalenz\Wiretable\Components\Filters;

use Illuminate\View\View;
use Spatie\QueryBuilder\AllowedFilter;

abstract class Filter extends AllowedFilter
{
    protected array $options = [];
    protected ?string $label = null;
    protected bool $required = false;
    protected $value;

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label ?? $this->name;
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

    public function getValue(?string $value)
    {
        $newValue = method_exists($this, 'castValue') ? $this->castValue($value) : $value;
        return ($newValue !== $this->getDefault()) ? $newValue : null;
    }

    /**
     * @return View
     */
    public function renderIt(): View
    {
        return $this->render()->with([
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'options' => $this->getOptions(),
            'required' => $this->required,
            'value' => $this->value
        ]);
    }

    abstract public function render(): View;
}
