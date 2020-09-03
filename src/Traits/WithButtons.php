<?php

namespace Sashalenz\Wiretable\Traits;

use Illuminate\Support\Collection;
use Sashalenz\Wiretable\Components\Buttons\DeleteButton;
use Sashalenz\Wiretable\Components\Buttons\LinkButton;
use Sashalenz\Wiretable\Components\Buttons\ModalButton;
use Sashalenz\Wiretable\Components\Buttons\RestoreButton;
use Sashalenz\Wiretable\Components\Columns\ActionColumn;

trait WithButtons
{
    private string $indexView = 'index';
    private string $createView = 'create';
    private string $showView = 'show';
    private string $editView = 'edit';

    private ?Collection $actionButtons = null;
    public string $createButton = '';

    public function initializeWithButtons(): void
    {
        $this->actionButtons = collect();

        if (!isset($this->model)) {
            return;
        }

        $model = app($this->model);

        if (method_exists($model, 'getRoute') && $model->hasRoute($this->showView)) {
            $this->actionButtons->push(
                LinkButton::make($this->showView)
                    ->icon('heroicon-o-eye')
                    ->routeUsing(fn ($row) => route($row->getRoute($this->showView), $row))
                    ->displayIf(fn ($row) => is_null($row->deleted_at))
            );
        }

        if (method_exists($model, 'getRoute') && $model->hasRoute($this->editView)) {
            $this->actionButtons->push(
                ModalButton::make($this->editView)
                    ->icon('heroicon-o-pencil')
                    ->routeUsing(fn ($row) => route($row->getRoute($this->editView), $row))
                    ->displayIf(fn ($row) => is_null($row->deleted_at))
            );
        }

        if (method_exists($this->model, 'bootSoftDeletes')) {
            $this->actionButtons
                ->push(
                    DeleteButton::make('delete')
                        ->displayIf(fn ($row) => is_null($row->deleted_at))
                )
                ->push(
                    RestoreButton::make('restore')
                        ->displayIf(fn ($row) => !is_null($row->deleted_at))
                );
        } else {
            $this->actionButtons
                ->push(
//                    FIX
                    DeleteButton::make('delete')
                        ->displayIf(fn ($row) => optional(auth('admin')->user())->can('delete '.$model::RESOURCE))
                );
        }

        if (method_exists($model, 'getRoute') && $model->hasRoute($this->createView)) {
            $this->createButton = app($this->model)->getRoute($this->createView);
        }
    }

    public function delete($id): void
    {
        try {
            $model = $this->model::findOrFail($id);
            $model->delete();

            $this->dispatchBrowserEvent('alert', [
                'status' => 'success',
                'message' => 'Successfully deleted!'
            ]);
            $this->dispatchBrowserEvent('refresh-table');
        } catch (\RuntimeException $exception) {
            $this->dispatchBrowserEvent('alert', [
                'status' => 'fail',
                'message' => 'Unable to delete!'
            ]);
        }
    }

    public function restore($id): void
    {
        try {
            $model = $this->model::withTrashed()->findOrFail($id);
            $model->restore();

            $this->dispatchBrowserEvent('alert', [
                'status' => 'success',
                'message' => 'Successfully restored!'
            ]);
            $this->dispatchBrowserEvent('refresh-table');
        } catch (\RuntimeException $exception) {
            $this->dispatchBrowserEvent('alert', [
                'status' => 'fail',
                'message' => 'Unable to restore!'
            ]);
        }
    }

    protected function getActionColumn():? ActionColumn
    {
        $this->actionButtons = $this->buttons()
            ->merge($this->actionButtons);

        if (!$this->actionButtons->count()) {
            return null;
        }

        return ActionColumn::make('action')
            ->withButtons($this->actionButtons);
    }

    protected function buttons(): Collection
    {
        return collect();
    }
}
