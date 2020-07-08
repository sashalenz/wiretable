<?php

namespace Sashalenz\Wiretable;

use App\Filters\SearchFilter;
use Livewire\Component;

class ModelSearch extends Component
{
    public string $search = '';
    public bool $required = false;
    public string $name;
    public string $model;
    public ?string $label = null;
    public ?string $value = null;
    public bool $isOpen = false;

    public function mount(string $name, string $model, string $label = null, string $value = null, bool $required = false): void
    {
        $this->name = $name;
        $this->required = $required;
        $this->label = $label;
        $this->value = $value;
        $this->model = $model;
    }

    public function setSelected($value): void
    {
        $this->search = '';
        $this->value = $value;
        $this->isOpen = false;

        $this->emitUp('addFilter', $this->name, $value);
    }

    public function getSelectedProperty()
    {
        return $this->model::find($this->value);
    }

    public function getResultsProperty()
    {
        if (!$this->isOpen) {
            return collect();
        }

        return $this->model::query()
            ->when($this->search, new SearchFilter($this->search))
            ->orderByDesc((new $this->model)->getKeyName())
            ->take(20)
            ->get();
    }

    public function render()
    {
        return view('wiretable::model-search');
    }
}
