<?php

namespace Sashalenz\Wiretable\Components\Fields;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;
use RuntimeException;

abstract class Field extends Component
{
    public string $name;
    public ?string $title = null;
    public ?string $icon = null;
    public bool $required = false;
    public ?string $placeholder = null;
    public ?string $help = null;
    public string $type = 'text';
    public int $size = 6;

    protected array $rules = [];
    protected Collection $classes;
    protected ?Closure $styleCallback = null;
    protected ?Closure $displayCondition = null;

    public function __construct(
        string $name,
        ?string $title = null,
        ?string $icon = null,
        bool $required = false,
        ?string $placeholder = null,
        ?string $help = null,
        string $type = 'text',
        int $size = 6
    ) {
        $this->name = $name;
        $this->title = $title;
        $this->icon = $icon;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->help = $help;
        $this->type = $type;
        $this->size = $size;

        $this->classes = collect();
    }

    /**
     * @param string $title
     * @return $this
     */
    protected function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $icon
     * @return $this
     */
    protected function icon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    protected function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param int $size
     * @return $this
     */
    protected function size(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param string|null $placeholder
     * @return $this
     */
    protected function placeholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @param string $help
     * @return $this
     */
    protected function help(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    /**
     * @param array $rules
     * @return $this
     */
    protected function rules(array $rules): self
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * @return $this
     */
    protected function required(): self
    {
        $this->required = true;
        return $this;
    }

    /**
     * @param mixed ...$classes
     * @return $this
     */
    protected function class(...$classes): self
    {
        $this->classes->push($classes);
        return $this;
    }

    /**
     * @param Model $model
     * @return string|null
     */
    private function getClass(Model $model): ?string
    {
        $class = is_callable($this->styleCallback) ? call_user_func($this->styleCallback, $model) : null;

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
     * @return array
     */
    protected function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param callable $styleCallback
     * @return $this
     */
    protected function styleUsing(callable $styleCallback): self
    {
        $this->styleCallback = $styleCallback;
        return $this;
    }

    /**
     * @param callable $displayCondition
     * @return $this
     */
    protected function displayIf(callable $displayCondition): self
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

    /**
     * @param Model $model
     * @return View|null
     */
    public function renderIt(Model $model):? View
    {
        $condition = is_callable($this->displayCondition) ? call_user_func($this->displayCondition, $model) : true;

        if ((bool) $condition === false) {
            return null;
        }

        return $this->render()
            ->with([
                'class' => $this->getClass($model)
            ]);
    }

    abstract public function render(): View;
}
