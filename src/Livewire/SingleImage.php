<?php

namespace Sashalenz\Wiretable\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class SingleImage extends Component
{
    use WithFileUploads;

    public string $name;
    public ?string $value = null;
    public $photo;

    public function mount(string $name, string $value = null): void
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function updatedPhoto(): void
    {
        $file = config('livewire.temporary_file_upload.directory').'/'.$this->photo->getFilename();
        $this->emitUp('updatedMedia', $this->name, $file);
    }

    public function render()
    {
        return view('wiretable::livewire.single-image');
    }

}
