<?php

namespace Sashalenz\Wiretable;

use Illuminate\Database\Eloquent\Model;

abstract class CreateForm extends Wireform
{
    public string $model;

    public function getModelClassProperty():? Model
    {
        return app($this->model);
    }

    public function render()
    {
        return view('wiretable::defaults.create');
    }

    public function save(): void
    {
        try {
            $this->model::create($this->validated());

            $this->reset();
            $this->dispatchBrowserEvent('alert', [
                'status' => 'success',
                'message' => 'Successfully created!'
            ]);
            $this->dispatchBrowserEvent('refresh-table');
            $this->dispatchBrowserEvent('close-modal');
        } catch (\RuntimeException $exception) {
            $this->dispatchBrowserEvent('alert', [
                'status' => 'error',
                'message' => 'Unable to create!',
                'description' => $exception->getMessage()
            ]);
        }
    }
}
