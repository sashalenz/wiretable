<?php

namespace Sashalenz\Wiretable\Components\Actions;

use Closure;
use Illuminate\Support\Collection;

abstract class Action
{
    private string $name;
    private string $model;
    private string $width = 'w-full sm:w-1/2 lg:w-1/4';
    private ?string $title = null;
    private ?string $icon = null;
    private Collection $class;
    private ?Closure $displayCondition = null;

    /**
     * Action constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string|null $title
     * @return $this
     */
    public function title(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

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
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $model
     * @return $this
     */
    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param mixed ...$class
     * @return $this
     */
    public function class(...$class): self
    {
        $this->class->push($class);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClass(): ?string
    {
        return $this->class
            ->filter()
            ->flatten()
            ->implode(' ');
    }

    /**
     * @param string $width
     * @return $this
     */
    public function width(string $width): self
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return string
     */
    public function getWidth(): string
    {
        return $this->width;
    }

    /**
     * @param callable $displayCondition
     * @return $this
     */
    public function displayIf(callable $displayCondition): self
    {
        $this->displayCondition = $displayCondition;
        return $this;
    }

    /**
     * @param string $name
     * @return static
     */
    public static function make(string $name)
    {
        return new static($name);
    }
}
