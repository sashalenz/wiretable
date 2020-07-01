<?php

namespace Sashalenz\Wiretable\Traits;

use Sashalenz\Wiretable\Components\Columns\Column;

trait WithSorting
{
    public string $sort = 'id';
    public string $defaultSort = 'id';

    public function initializeWithSorting(): void
    {
        $this->sort = $this->resolveSort();
    }

    public function resolveSort()
    {
        return request()->query('sort', $this->sort);
    }

    public function resetSort(): void
    {
        $this->sort = $this->defaultSort;
        $this->request()->query->set('sort', $this->defaultSort);
    }

    public function updatedSort(): void
    {
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
        $this->request()->query->set('sort', $this->sort);
    }

    private function getAllowedSorts(): array
    {
        return $this->fields()
            ->filter(fn(Column $field) => $field->isSortable())
            ->map(fn(Column $field) => $field->getName())
            ->values()
            ->toArray();
    }
}
