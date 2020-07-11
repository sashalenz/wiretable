<?php

namespace Sashalenz\Wiretable\Traits;

use Illuminate\Support\Collection;
use Sashalenz\Wiretable\Components\Filters\Filter;

trait WithFiltering
{
    public ?string $filter = null;

    public function initializeWithFiltering(): void
    {
        $this->filter = $this->resolveFilter();
        $this->request()->query->set('filter', $this->expandFilters()->toArray());
    }

    public function resolveFilter()
    {
        return request()->query('filter', $this->filter);
    }

    public function addFilter($key, $value): void
    {
        $filter = $this->filters()->first(fn (Filter $row) => $row->getName() === $key);

        $filters = $this->expandFilters();
        $filters->put($filter->getName(), $filter->getValue($value));
        $filters = $filters->reject(fn ($filter) => is_null($filter));

        $this->filter = $this->shrinkFilters($filters);

        $this->request()->query->set('filter', $filters->toArray());

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    protected function expandFilters() : Collection
    {
        if (!$this->filter) {
            return collect();
        }

        return collect(explode(';', $this->filter))
            ->mapWithKeys(static function ($filter) {
                if (strpos($filter, ':') === false) {
                    return [$filter => true];
                }
                [$k, $v] = explode(':', $filter);
                return [$k => $v];
            });
    }

    protected function shrinkFilters(Collection $filters): string
    {
        return $filters
            ->map(fn ($filter, $key) => implode(':', [$key, $filter]))
            ->implode(';');
    }

    public function resetFilter(): void
    {
        $this->filter = '';
        $this->request()->query->set('filter', null);
    }

    public function getFiltersProperty(): array
    {
        return $this->filters()
            ->each(fn (Filter $filter) => $filter->value($this->expandFilters()->get($filter->getName())))
            ->toArray();
    }

    protected function filters(): Collection
    {
        return collect();
    }
}
