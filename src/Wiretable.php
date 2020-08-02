<?php


namespace Sashalenz\Wiretable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;
use Sashalenz\Wiretable\Filters\SearchFilter;
use Sashalenz\Wiretable\Components\Actions\Action;
use Sashalenz\Wiretable\Components\Columns\ActionColumn;
use Sashalenz\Wiretable\Components\Columns\CheckboxColumn;
use Sashalenz\Wiretable\Components\Columns\Column;
use Sashalenz\Wiretable\Traits\WithFiltering;
use Sashalenz\Wiretable\Traits\WithSearching;
use Sashalenz\Wiretable\Traits\WithSorting;
use Sashalenz\Wiretable\Traits\WithPagination;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\QueryBuilderRequest;

abstract class Wiretable extends Component
{
    use WithPagination,
        WithFiltering,
        WithSorting,
        WithSearching;

    protected string $model;

    protected $request;

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

    public function getUpdatesQueryString(): array
    {
        return array_merge($this->updatesQueryString, [
            'filter' => ['except' => ''],
            'search' => ['except' => ''],
            'page' => ['except' => 1],
            'sort' => ['except' => $this->defaultSort]
        ]);
    }

    public function getSortProperty(): string
    {
        return $this->sort;
    }

    public function getColumnsProperty(): array
    {
        $actionColumn = $this->getActionColumn();
        $checkboxColumn = $this->getCheckboxColumn();

        return $this->columns()
            ->each(
                fn (Column $column) => !is_null($this->search) && $column->setHighlight($this->search)
            )
            ->when(
                !is_null($actionColumn),
                fn (Collection $rows) => $rows->push($actionColumn)
            )
            ->when(
                !is_null($checkboxColumn),
                fn (Collection $rows) => $rows->prepend($checkboxColumn)
            )
            ->toArray();
    }

    public function getActionsProperty(): array
    {
        return $this->actions()
            ->each(fn (Action $action) => $action->setModel($this->model))
            ->toArray();
    }

    public function getDataProperty()
    {
        return QueryBuilder::for($this->query(), $this->request())
            ->allowedFilters($this->filters()->toArray())
            ->defaultSort($this->defaultSort)
            ->allowedSorts(...$this->getAllowedSorts())
            ->when($this->search && !$this->disableSearch, new SearchFilter($this->search))
            ->when(
                $this->simplePagination === true,
                fn (QueryBuilder $query) => $query->simplePaginate($this->perPage),
                fn (QueryBuilder $query) => $query->paginate($this->perPage)->onEachSide(1)
            );
    }

    protected function getActionColumn():? ActionColumn
    {
        if (!$this->buttons()->count()) {
            return null;
        }

        return ActionColumn::make('Action')
            ->withButtons($this->buttons()->toArray());
    }

    protected function getCheckboxColumn():? CheckboxColumn
    {
        if (!$this->actions()->count()) {
            return null;
        }

        return CheckboxColumn::make('Checkbox');
    }

    abstract public function getTitleProperty(): string;

    abstract protected function query(): Builder;

    protected function columns(): Collection
    {
        return collect();
    }

    protected function buttons(): Collection
    {
        return collect();
    }

    protected function actions(): Collection
    {
        return collect();
    }
}
