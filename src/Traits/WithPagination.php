<?php

namespace Sashalenz\Wiretable\Traits;

use Illuminate\Pagination\Paginator;

trait WithPagination
{
    public int $page = 1;
    public int $perPage = 20;
    public bool $simplePagination = false;

    public function getUpdatesQueryString(): array
    {
        return array_merge(['page' => ['except' => 1]], $this->updatesQueryString);
    }

    public function initializeWithPagination(): void
    {
        $this->page = $this->resolvePage();

        Paginator::currentPageResolver(function () {
            return $this->page;
        });

        Paginator::defaultView($this->paginationView());
        Paginator::defaultSimpleView($this->simplePaginationView());
    }

    public function paginationView(): string
    {
        return 'wiretable::partials.pagination';
    }

    public function simplePaginationView(): string
    {
        return 'wiretable::partials.simple-pagination';
    }

    public function previousPage(): void
    {
        --$this->page;
    }

    public function nextPage(): void
    {
        ++$this->page;
    }

    public function gotoPage($page): void
    {
        $this->page = $page;
    }

    public function resetPage(): void
    {
        $this->page = 1;
    }

    public function resolvePage()
    {
        return request()->query('page', $this->page);
    }
}
