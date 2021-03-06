<?php

namespace Sashalenz\Wiretable\Components\Columns;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;
use RuntimeException;

abstract class Column extends Component
{
    private string $name;
    private Collection $class;
    private ?string $title = null;
    private bool $sortable = false;
    private ?int $width = null;
    private ?string $highlight = null;
    private ?Closure $styleCallback = null;
    private ?Closure $displayCallback = null;
    private ?Closure $displayCondition = null;
    private ?string $currentSort = null;

    protected bool $hasHighlight = false;

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
        $classes = collect();

        $classes->push($this->class);

        $class = is_callable($this->styleCallback) ? call_user_func($this->styleCallback, $row) : null;

        if (!is_string($class) && !is_null($class)) {
            throw new RuntimeException('Return value must be a string');
        }

        $classes->push($class);

        if ($this->hasHighlight && !is_null($this->getHighlight()) && ($this->getHighlight() === $this->getValue($row))) {
            $classes->push('text-green-700 font-semibold');
        }

        return $classes
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
     * @param string $highlight
     * @return $this
     */
    public function setHighlight(string $highlight): self
    {
        $this->highlight = $highlight;
        return $this;
    }

    /**
     * @return string|null
     */
    private function getHighlight():? string
    {
        return $this->highlight;
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
     * @param callable $displayCondition
     * @return $this
     */
    public function displayIf(callable $displayCondition): self
    {
        $this->displayCondition = $displayCondition;
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

    public function toCenter(): self
    {
        $this->class->push('text-center');
        return $this;
    }

    public function setCurrentSort($sort): self
    {
        $this->currentSort = $sort;
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
     * @param $row
     * @return string|null
     */
    protected function getValue($row):? string
    {
        return data_get($row->toArray(), $this->getName());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|string|null
     */
    public function renderTitle()
    {
        if ($this->isSortable() && !is_null($this->currentSort)) {
            return view('wiretable::partials.table-title')
                ->with([
                    'name' => $this->getName(),
                    'title' => $this->getTitle(),
                    'isCurrentSort' => str_replace('-', '', $this->currentSort) === $this->getName(),
                    'isSortUp' => $this->currentSort === $this->getName(),
                    'sort' => $this->currentSort
                ]);
        }

        return $this->getTitle();
    }

    /**
     * @param $row
     * @return View|mixed|string
     */
    public function renderIt($row)
    {
        $condition = is_callable($this->displayCondition) ? call_user_func($this->displayCondition, $row) : true;

        if ((bool) $condition === false) {
            return null;
        }

        if ($this->render() !== null) {
            return $this
                ->render()
                ->with([
                    'id' => $row->{$row->getKeyName()},
                    'name' => $this->getName(),
                    'data' => $row->{$this->getName()},
                    'row' => $row
                ]);
        }

        if (is_callable($this->displayCallback)) {
            return call_user_func($this->displayCallback, $row);
        }

        return $this->getValue($row);
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
