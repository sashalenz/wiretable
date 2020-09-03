<?php

namespace Sashalenz\Wiretable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Sashalenz\Wiretable\Components\Fields\Field;

abstract class Wireform extends Component
{
    public function __construct($id)
    {
        foreach ($this->fields() as $field) {
            $this->{$field->name} = $field->default ?? null;

            if ($field->hasCast()) {
                $this->casts[$field->name] = $field->getCast();
            }
        }

        parent::__construct($id);
    }

    protected $listeners = [
        'updatedChild'
    ];

    private function getRules(bool $required = false): array
    {
        return $this->fields()
            ->filter(fn (Field $field) => $field->getRules())
            ->mapWithKeys(fn (Field $field) => [
                $field->name => $field->getRules()
            ])
            ->toArray();
    }

    protected function fillExistedModel(): void
    {
        $this->fields()
            ->each(fn (Field $field) => $this->{$field->name} = $this->model->{$field->name});
    }

    /**
     * @param $field
     * @throws ValidationException
     */
    public function updated($field): void
    {
        $rules = collect($this->getRules())
            ->filter(fn ($value, $key) => $key === $field)
            ->map(fn ($value) => collect($value)
                ->reject(fn ($rule) => in_array($rule, ['required', 'confirmed']))
                ->values()
                ->toArray()
            );

        $this->validateOnly($field, $rules->toArray());
    }

    protected function validated(): array
    {
        return $this->validate($this->getRules());
    }

    public function updatedChild($name, $value): void
    {
        if (!property_exists($this, $name)) {
            return;
        }

        $this->{$name} = $value;
    }

    public function getFieldsProperty(): array
    {
        return $this->fields()
            ->each(fn (Field $field) => $field->setValue($this->{$field->name}))
            ->toArray();
    }

    protected function fields(): Collection
    {
        return collect();
    }

    public function propertyIsPublicAndNotDefinedOnBaseClass($propertyName): bool
    {
        return $this->fields()
                ->pluck('name')
                ->search($propertyName) !== false;
    }

    public function getPublicPropertiesDefinedBySubClass(): array
    {
        return $this->fields()
            ->mapWithKeys(function (Field $field) {
                return [$field->name => $this->{$field->name} ?? null];
            })
            ->merge(parent::getPublicPropertiesDefinedBySubClass())
            ->all();
    }

    abstract public function getModelClassProperty():? Model;

    abstract public function getTitleProperty(): string;
}
