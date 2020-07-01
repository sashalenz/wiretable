<?php

namespace Sashalenz\Wiretable\Components\Columns;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;
use RuntimeException;

abstract class Column extends Component
{
    protected string $name;
    protected ?string $title = null;
    protected bool $sortable = false;
    protected ?string $icon = null;
    protected Collection $class;
    protected ?int $width = null;
    protected ?Closure $styleCallback = null;
    protected ?Closure $displayCallback = null;

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
     * @return $this
     */
    public function sortable(): self
    {
        $this->sortable = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @param string $sort
     * @param bool $abs
     * @return bool
     */
    public function isCurrentSort(string $sort, bool $abs = true) : bool
    {
        if ($abs === true) {
            return str_replace('-', '', $sort) === $this->getName();
        }

        return $sort === $this->getName();
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
    public function getClass($row): ?string
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param int|null $width
     * @return $this
     */
    public function width(?int $width): self
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @param callable $displayCallback
     * @return $this
     */
    public function displayUsing(callable $displayCallback): self
    {
        $this->displayCallback = $displayCallback;
        return $this;
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

    public function toCenter(): Column
    {
        $this->class->push('text-center');
        return $this;
    }

    /**
     * @return string
     */
    public function getSlotName(): string
    {
        return sprintf('column_%s', $this->getName());
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
     * @return View|mixed|string
     */
    public function renderIt($row)
    {
        if ($this->render() !== null) {
            return $this
                ->render()
                ->with([
                    'row' => $row
                ]);
        }

        if (is_callable($this->displayCallback)) {
            return call_user_func($this->displayCallback, $row);
        }

        return data_get($row->toArray(), $this->name);
    }
}
