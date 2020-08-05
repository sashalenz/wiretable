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
    public $value = null;

    protected array $rules = [];
    protected Collection $classes;
    protected ?Closure $styleCallback = null;
    protected ?Closure $displayCondition = null;

    protected $except = [
        'renderIt',
        'make',
        'setValue',
        'setIcon',
        'setRules',
        'setType',
        'setSize',
        'isRequired',
        'setPlaceholder',
        'setHelp',
        'addClass',
        'getRules',
        'setOptions'
    ];

    public function __construct(
        string $name,
        ?string $title = null,
        $value = null,
        ?string $icon = null,
        bool $required = false,
        ?string $placeholder = null,
        ?string $help = null,
        string $type = 'text',
        int $size = 6
    ) {
        $this->name = $name;
        $this->title = $title;
        $this->value = $value;
        $this->icon = $icon;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->help = $help;
        $this->type = $type;
        $this->size = $size;

        $this->classes = collect();
    }

    /**
     * @param string $icon
     * @return $this
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param string|null $placeholder
     * @return $this
     */
    public function setPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @param string $help
     * @return $this
     */
    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    /**
     * @param array $rules
     * @return $this
     */
    public function setRules(array $rules): self
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * @return $this
     */
    public function isRequired(): self
    {
        $this->required = true;
        return $this;
    }

    /**
     * @param mixed ...$classes
     * @return $this
     */
    public function addClass(...$classes): self
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

        $this->classes->push($class);

        return $this->classes
            ->filter()
            ->flatten()
            ->implode(' ');
    }

    /**
     * @return array
     */
    public function getRules(): array
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

    public function getDataArray(): array
    {
        return collect($this->data())
            ->filter( fn ($value, $key) => !in_array($key, ['getDataArray', 'attributes']))
            ->mapWithKeys( fn ($value, $key) => [$key => is_null($value) ? '' : $value])
            ->toArray();
    }

    /**
     * @param string $name
     * @param string|null $title
     * @return static
     */
    public static function make(string $name, ?string $title = null)
    {
        return new static($name, $title);
    }

    /**
     * @param Model|null $model
     * @return View|null
     */
    public function renderIt(?Model $model = null):? View
    {
        $condition = is_callable($this->displayCondition) ? call_user_func($this->displayCondition, $model) : true;

        if ((bool) $condition === false) {
            return null;
        }

        info(session()->get('errors'));

        return $this
//            ->withAttributes([
//                'class' => ($model) ? $this->getClass($model) : null
//            ])
            ->render()
            ->with($this->data())
            ->with([
                'hasError' => false
            ]);
    }
}
