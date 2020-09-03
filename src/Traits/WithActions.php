<?php

namespace Sashalenz\Wiretable\Traits;

use Illuminate\Support\Collection;
use Sashalenz\Wiretable\Components\Actions\Action;
use Sashalenz\Wiretable\Components\Columns\CheckboxColumn;

trait WithActions
{
    private ?Collection $actions = null;

    public function initializeWithActions(): void
    {
        $this->actions = collect();
    }

    public function getActionsProperty(): Collection
    {
        return $this->actions()
            ->each(
                fn (Action $action) => $action->setModel($this->model)
            );
    }

    protected function getCheckboxColumn():? CheckboxColumn
    {
        $this->actions = $this->actions()
            ->merge($this->actions);

        if (!$this->actions->count()) {
            return null;
        }

        return CheckboxColumn::make('checkbox');
    }

    protected function actions(): Collection
    {
        return collect();
    }
}
