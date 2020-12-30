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
    public bool $required = false;
    public ?string $placeholder = null;
    public ?string $help = null;
    public ?int $size = 6;
    public $default = null;
    public $value = null;
    public ?string $wireModel = null;
    public bool $requiredIcon = true;

    protected array $rules = [];
    protected Collection $classes;
    protected ?Closure $styleCallback = null;
    protected ?Closure $displayCondition = null;

    protected $except = [
        'renderIt',
        'make',
        'setValue',
        'setDefault',
        'setIcon',
        'setRules',
        'setType',
        'setSize',
        'isRequired',
        'setPlaceholder',
        'setHelp',
        'addClass',
        'getRules',
        'setOptions',
        'setCast',
        'getCast',
        'hasCast'
    ];

    public function __construct(
        string $name,
        ?string $title = null,
        $value = null,
        ?bool $required = false,
        ?string $placeholder = null,
        $default = null,
        ?string $help = null,
        ?int $size = 6
    ) {
        $this->name = $name;
        $this->title = $title;
        $this->value = $this->castValue($value);
        $this->required = (bool) $required;
        $this->placeholder = $placeholder;
        $this->default = $this->castValue($default);
        $this->help = $help;
        $this->size = $size;

        $this->classes = collect();
    }

    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function setPlaceholder(?string $placeholder = null): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function setValue($value): self
    {
        $this->value = $this->castValue($value);
        return $this;
    }

    public function setDefault(string $default): self
    {
        $this->default = $this->castValue($default);
        return $this;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function setRules(array $rules): self
    {
        $this->rules = $rules;
        return $this;
    }

    public function isRequired(): self
    {
        $this->required = true;
        return $this;
    }

    public function hideRequiredIcon(): self
    {
        $this->requiredIcon = false;
        return $this;
    }

    public function addClass(...$classes): self
    {
        $this->classes->push($classes);
        return $this;
    }

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

    public function hasRules(): bool
    {
        return count($this->rules);
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function styleUsing(callable $styleCallback): self
    {
        $this->styleCallback = $styleCallback;
        return $this;
    }

    public function displayIf(callable $displayCondition): self
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

    public function castValue($value)
    {
        return $value;
    }

    public static function make(string $name, ?string $title = null): static
    {
        return new static($name, $title);
    }

    public function renderIt(?Model $model = null): Closure|\Illuminate\Contracts\Support\Htmlable|\Illuminate\Contracts\View\View|View|string|null
    {
        $condition = is_callable($this->displayCondition) ? call_user_func($this->displayCondition, $model) : true;

        if ((bool) $condition === false) {
            return null;
        }

        return $this->render()->with($this->data());
    }
}
