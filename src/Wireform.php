<?php

namespace Sashalenz\Wiretable;

use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Sashalenz\Wiretable\Components\Fields\Field;

abstract class Wireform extends Component
{
    protected string $layout = 'layouts.app';
    public array $media = [];

    protected $listeners = [
        'updatedChild',
        'updatedMedia',
    ];

    public function rules(): array
    {
        return $this->fields()
            ->filter(fn (Field $field) => $field->hasRules())
            ->mapWithKeys(fn (Field $field) => ["model.{$field->name}" => $field->getRules()])
            ->toArray();
    }

    protected function defaults(): array
    {
        return $this->fields()
            ->filter(fn (Field $field) => !is_null($field->default))
            ->mapWithKeys(fn (Field $field) => [$field->name => $field->default])
            ->toArray();
    }

    /**
     * @param $field
     * @throws ValidationException
     */
    public function updated($field): void
    {
        info($this->rules());
        $rules = collect($this->rules())
            ->filter(fn ($value, $key) => $key === $field)
            ->mapWithKeys(fn ($rules, $key) => [
                $key => collect($rules)
                    ->reject(fn ($rule) => in_array($rule, ['required', 'confirmed']))
                    ->values()
                    ->toArray()
            ])
            ->toArray();

        info($rules);

        if (empty($rules)) {
            return;
        }

        $this->validateOnly(
            $field,
            $rules
        );
    }

    public function updatedChild($name, $value): void
    {
        $this->model->{$name} = $value;
    }

    public function updatedMedia($name, $value): void
    {
        $this->media[$name] = $value;
    }

    public function getFieldsProperty(): array
    {
        return $this->fields()
            ->each(fn (Field $field) => $field->wireModel = "model.{$field->name}")
            ->toArray();
    }

    protected function fields(): Collection
    {
        return collect();
    }

    abstract public function getTitleProperty(): string;
}
