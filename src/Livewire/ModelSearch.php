<?php

namespace Sashalenz\Wiretable\Livewire;

use Livewire\Component;
use Sashalenz\Wiretable\Filters\SearchFilter;

class ModelSearch extends Component
{
    public string $search = '';
    public bool $required = false;
    public string $name;
    public string $model;
    public ?string $placeholder = null;
    public ?string $value = null;
    public bool $isOpen = false;
    public bool $readonly = false;
    public int $limit = 20;

    public function mount(string $name, string $model, string $placeholder = null, string $value = null, bool $required = false, bool $readonly = true): void
    {
        $this->name = $name;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->model = $model;
        $this->readonly = $readonly;
    }

    public function setSelected($value): void
    {
        $this->search = '';
        $this->isOpen = false;

        if ($this->value === $value) {
            return;
        }

        $this->value = $value;

        $this->emitUp('updatedChild', $this->name, $this->value);
    }

    public function getSelectedProperty()
    {
        return $this->model::find($this->value);
    }

    public function getResultsProperty()
    {
        return $this->model::query()
            ->when($this->search, new SearchFilter($this->search))
            ->orderBy((new $this->model)->getKeyName())
            ->take($this->limit)
            ->get();
    }

    public function render()
    {
        return view('wiretable::livewire.model-search');
    }
}
