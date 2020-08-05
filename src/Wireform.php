<?php

namespace Sashalenz\Wiretable;

use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Sashalenz\Wiretable\Components\Fields\Field;

abstract class Wireform extends Component
{
    protected $model;

    private function getRules(): array
    {
        return $this->fields()
            ->filter(fn (Field $field) => $field->getRules())
            ->mapWithKeys(fn (Field $field) => [
                $field->name => $field->getRules()
            ])
            ->toArray();
    }

    /**
     * @param $field
     * @throws ValidationException
     */
    public function updated($field): void
    {
        $this->validateOnly($field, $this->getRules());
    }

    public function validated(): array
    {
        return $this->validate($this->getRules());
    }

    public function getFieldsProperty(): array
    {
        return $this->fields()->toArray();
    }

    abstract public function getTitleProperty(): string;

    protected function fields(): Collection
    {
        return collect();
    }
}
