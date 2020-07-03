<?php

namespace Sashalenz\Wiretable\Traits;

trait WithSearching
{
    public string $search = '';
    public bool $disableSearch = false;

    public function initializeWithSearching(): void
    {
        $this->search = $this->resolveSearching();
    }

    public function resolveSearching()
    {
        return request()->query('search', $this->search);
    }

    public function updatingSearch(): void
    {
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function resetSearch(): void
    {
        $this->search = '';
    }
}
