<?php

namespace Sashalenz\Wiretable;

use Illuminate\Database\Eloquent\Model;

abstract class CreateForm extends Wireform
{
    public function mount(): void
    {
        $this->model = new $this->initialize($this->defaults());
    }

    public function getModelClassProperty(): Model
    {
        return $this->model;
    }

    public function render()
    {
        return view('wiretable::defaults.create')
            ->extends($this->layout);
    }

    public function save(): void
    {
        try {
            $this->validate($this->rules());
            $this->model->save();

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
