<?php

namespace Sashalenz\Wiretable\Components\Buttons;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use RuntimeException;

abstract class Button extends Component
{
    protected string $name;
    protected ?string $title = null;
    protected ?string $icon = null;
    protected Collection $class;
    protected ?Closure $routeCallback = null;
    protected ?Closure $styleCallback = null;
    protected ?Closure $displayCondition = null;

    public function __construct($name)
    {
        $this->name = $name;
        $this->class = collect();
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
    private function getIcon(): ?string
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
     * @param mixed ...$class
     * @return $this
     */
    public function class(...$class): self
    {
        $this->class->push($class);
        return $this;
    }

    /**
     * @param $row
     * @return string|null
     */
    private function getClass($row): ?string
    {
        $class = is_callable($this->styleCallback) ? call_user_func($this->styleCallback, $row) : null;

        if (!is_string($class) && !is_null($class)) {
            throw new RuntimeException('Return value must be a string');
        }

        $this->class->push($class);

        return $this->class
            ->filter()
            ->flatten()
            ->implode(' ');
    }

    /**
     * @param callable $styleCallback
     * @return $this
     */
    public function styleUsing(callable $styleCallback): self
    {
        $this->styleCallback = $styleCallback;
        return $this;
    }

    /**
     * @param callable $routeCallback
     * @return $this
     */
    public function routeUsing(callable $routeCallback): self
    {
        $this->routeCallback = $routeCallback;
        return $this;
    }

    /**
     * @return bool
     */
    private function hasRouteCallback(): bool
    {
        return is_callable($this->routeCallback);
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
     * @param $row
     * @return bool
     */
    private function canDisplay($row): bool
    {
        return is_callable($this->displayCondition) ? call_user_func($this->displayCondition, $row) : true;
    }

    /**
     * @param $row
     * @return string|null
     */
    private function getRoute($row):? string
    {
        return is_callable($this->routeCallback) ? call_user_func($this->routeCallback, $row) : null;
    }

    /**
     * @param string $name
     * @return static
     */
    public static function make(string $name)
    {
        return new static($name);
    }

    /**
     * @param $row
     * @return mixed
     */
    public function renderIt($row)
    {
        if (!$this->canDisplay($row)) {
            return null;
        }

        if (!$this->getTitle() && !$this->getIcon()) {
            throw new RuntimeException('Title or Icon must be presented');
        }

        return $this->render()
            ->with([
                'row' => $row,
                'class' => $this->getClass($row),
                'route' => $this->getRoute($row),
                'icon' => $this->getIcon(),
                'title' => $this->getTitle()
            ]);
    }
}
