<?php


namespace Sashalenz\Wiretable;

use App\Filters\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Sashalenz\Wiretable\Components\Buttons\Button;
use Sashalenz\Wiretable\Components\Columns\ActionColumn;
use Sashalenz\Wiretable\Traits\WithFiltering;
use Sashalenz\Wiretable\Traits\WithSearching;
use Sashalenz\Wiretable\Traits\WithSorting;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\QueryBuilderRequest;

abstract class Wiretable extends Component
{
    use WithPagination,
        WithFiltering,
        WithSorting,
        WithSearching;

    public int $perPage = 20;

    protected $request;

    protected $listeners = [
        'refresh',
        'resetTable'
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
        return $this->columns()
            ->when(
                !is_null($actionColumn),
                fn (Collection $rows) => $rows->push($actionColumn)
            )
            ->toArray();
    }

    public function getDataProperty()
    {
        return QueryBuilder::for($this->query(), $this->request())
            ->allowedFilters($this->filters()->toArray())
            ->defaultSort($this->defaultSort)
            ->allowedSorts(...$this->getAllowedSorts())
            ->when($this->search && !$this->disableSearch, new SearchFilter($this->search))
            ->paginate($this->perPage)
            ->onEachSide(1);
    }

    public function paginationView(): string
    {
        return 'partials.pagination';
    }

    protected function getActionColumn():? ActionColumn
    {
        $filteredButtons = $this->buttons()
            ->filter(fn (Button $button) => $button->hasRouteCallback());

        if (!$filteredButtons->count()) {
            return null;
        }

        return ActionColumn::make('Action')
            ->withButtons($filteredButtons->toArray());
    }

    abstract public function getTitleProperty(): string;

    abstract protected function query(): Builder;

    abstract protected function columns(): Collection;

    abstract protected function buttons(): Collection;
}
