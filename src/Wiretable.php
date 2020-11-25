<?php

namespace Sashalenz\Wiretable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;
use Sashalenz\Wiretable\Components\Columns\Column;
use Sashalenz\Wiretable\Filters\SearchFilter;
use Sashalenz\Wiretable\Traits\WithActions;
use Sashalenz\Wiretable\Traits\WithButtons;
use Sashalenz\Wiretable\Traits\WithFiltering;
use Sashalenz\Wiretable\Traits\WithPagination;
use Sashalenz\Wiretable\Traits\WithSearching;
use Sashalenz\Wiretable\Traits\WithSorting;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\QueryBuilderRequest;

abstract class Wiretable extends Component
{
    use WithPagination,
        WithFiltering,
        WithSorting,
        WithSearching,
        WithButtons,
        WithActions;

    protected string $model;
    protected $request;
    protected string $layout = 'layouts.app';

    protected $listeners = [
        'refresh',
        'resetTable',
        'addFilter'
    ];

    public function refresh(): void
    {
//
    }

    public function resetTable(): void
    {
        $this->resetPage();
        $this->resetFilter();
        $this->resetSort();
        $this->resetSearch();
    }

    /**
     * @return QueryBuilderRequest
     */
    public function request(): QueryBuilderRequest
    {
        if (!$this->request) {
            $this->request = app(QueryBuilderRequest::class);
        }

        return $this->request;
    }

    public function getColumnsProperty(): Collection
    {
        $actionColumn = $this->getActionColumn();
        $checkboxColumn = $this->getCheckboxColumn();

        return $this->columns()
            ->when(
                method_exists($this,'initializeWithSearching') && !is_null($this->getSearchProperty()),
                fn (Collection $rows) => $rows->each(fn (Column $column) => $column->setHighlight($this->getSearchProperty()))
            )
            ->when(
                method_exists($this,'initializeWithSorting') && !is_null($this->getSortProperty()),
                fn (Collection $rows) => $rows->each(fn (Column $column) => $column->setCurrentSort($this->getSortProperty()))
            )
            ->when(
                method_exists($this,'initializeWithButtons') && !is_null($actionColumn),
                fn (Collection $rows) => $rows->push($actionColumn)
            )
            ->when(
                method_exists($this,'initializeWithActions') && !is_null($checkboxColumn),
                fn (Collection $rows) => $rows->prepend($checkboxColumn)
            );
    }

    public function getDataProperty()
    {
        $builder = QueryBuilder::for($this->query(), $this->request());

        if (method_exists($this, 'initializeWithFiltering')) {
            $builder = $builder->allowedFilters($this->getFiltersProperty()->toArray());
        }

        if (method_exists($this, 'initializeWithSorting')) {
            $builder = $builder->defaultSort($this->defaultSort)->allowedSorts(...$this->getAllowedSorts());
        }

        return $builder
            ->when(
                method_exists($this, 'initializeWithSearching') && !$this->disableSearch && $this->getSearchProperty(),
                new SearchFilter($this->getSearchProperty())
            )
            ->when(
                $this->simplePagination === true,
                fn (Builder $query) => $query->simplePaginate($this->perPage),
                fn (Builder $query) => $query->paginate($this->perPage)->onEachSide(1)
            );
    }
//
//    public function getPublicPropertiesDefinedBySubClass(): array
//    {
//        $properties = collect()
//            ->when(
//                method_exists($this, 'initializeWithSorting'),
//                fn (Collection $collection) => $collection->put(
//                    self::$sortKey,
//                    property_exists($this, self::$sortKey) ? $this->{self::$sortKey} : $this->defaultSort
//                )
//            )
//            ->when(
//                method_exists($this, 'initializeWithPagination'),
//                fn (Collection $collection) => $collection->put(
//                    self::$pageKey,
//                    property_exists($this, self::$pageKey) ? $this->{self::$pageKey} : 1
//                )
//            )
//            ->when(
//                method_exists($this, 'initializeWithSearching'),
//                fn (Collection $collection) => $collection->put(
//                    self::$searchKey,
//                    property_exists($this, self::$searchKey) ? $this->{self::$searchKey} : ''
//                )
//            )
//            ->when(
//                method_exists($this, 'initializeWithFiltering'),
//                fn (Collection $collection) => $collection->put(
//                    self::$filterKey,
//                    property_exists($this, self::$filterKey) ? $this->{self::$filterKey} : ''
//                )
//            )
//            ->toArray();
//
//        return array_merge(parent::getPublicPropertiesDefinedBySubClass(), $properties);
//    }

    public function render()
    {
        return view('wiretable::defaults.index')->extends($this->layout);
    }

    abstract public function getTitleProperty(): string;

    abstract protected function query(): Builder;

    abstract protected function columns(): Collection;
}
