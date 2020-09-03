<?php

namespace Sashalenz\Wiretable;

use Illuminate\Database\Eloquent\Model;

abstract class EditForm extends Wireform
{
    public $model;

    public function getModelClassProperty():? Model
    {
        return $this->model;
    }

    public function render()
    {
        return view('wiretable::defaults.edit');
    }

    public function save(): void
    {
        try {
            $this->model->fill($this->validated());

            if ($this->model->isClean()) {
                $this->dispatchBrowserEvent('alert', [
                    'status' => 'info',
                    'message' => 'Nothing to update!'
                ]);
            } else {
                $this->model->save();
                $this->dispatchBrowserEvent('alert', [
                    'status' => 'success',
                    'message' => 'Successfully updated!'
                ]);
                $this->dispatchBrowserEvent('refresh-table');
                $this->dispatchBrowserEvent('close-modal');
            }
        } catch (\RuntimeException $exception) {
            $this->dispatchBrowserEvent('alert', [
                'status' => 'error',
                'message' => 'Unable to create!',
                'description' => $exception->getMessage()
            ]);
        }
    }

}
