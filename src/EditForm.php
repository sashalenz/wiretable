<?php

namespace Sashalenz\Wiretable;

use Illuminate\Database\Eloquent\Model;
use Sashalenz\Wiretable\Components\Fields\Field;

abstract class EditForm extends Wireform
{
    public function getModelClassProperty(): Model
    {
        return $this->model;
    }

    public function render()
    {
        return view('wiretable::defaults.edit')
            ->extends($this->layout);
    }

    public function save(): void
    {
        try {
            $this->validate();

            if ($this->getModelClassProperty()->isClean()) {
                $this->dispatchBrowserEvent('alert', [
                    'status' => 'info',
                    'message' => 'Nothing to update!'
                ]);
            } else {
                $this->getModelClassProperty()->save();
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
