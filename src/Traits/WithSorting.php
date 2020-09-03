<?php

namespace Sashalenz\Wiretable\Traits;

use Sashalenz\Wiretable\Components\Columns\Column;

trait WithSorting
{
    protected string $defaultSort = '-id';
    protected static string $sortKey = 'sort';

    protected function initializeWithSorting(): void
    {
        $this->updatesQueryString[self::$sortKey] = ['except' => $this->defaultSort];

        $this->setSort($this->resolveSort());
    }

    protected function resetSort(): void
    {
        $this->setSort($this->defaultSort);
    }

    private function resolveSort()
    {
        return request()->query(self::$sortKey, $this->defaultSort);
    }

    private function setSort($sort): void
    {
        $this->{self::$sortKey} = (string) $sort;
        $this->request()->query->set('sort', (string) $sort);
    }

    private function getAllowedSorts(): array
    {
        return $this->columns()
                ->filter(fn(Column $column) => $column->isSortable())
                ->map(fn(Column $column) => $column->getName())
                ->values()
                ->toArray() ?? [];
    }

    public function sortBy($columnName): void
    {
        // determinate sort by clicked column
        $sort = ($this->{self::$sortKey} !== $columnName) ? $columnName : sprintf('-%s', $columnName);

        // call private function that setting sort
        $this->setSort($sort);

        // reset page if is not first
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function getSortProperty(): string
    {
        return $this->{self::$sortKey};
    }
}
