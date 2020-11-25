<?php

namespace Sashalenz\Wiretable\Components\Fields;

use Illuminate\View\Component;

class LayoutField extends Component
{
    public string $name;
    public ?string $title = null;
    public ?string $wireModel = null;
    public int $size;
    public ?string $class;
    public ?string $help;
    public bool $required = false;
    public bool $requiredIcon = true;

    public function __construct(string $name, string $title = null, string $wireModel = null, int $size = 6, string $class = null, string $help = null, bool $required = false, bool $requiredIcon = true)
    {
        $this->name = $name;
        $this->title = $title;
        $this->wireModel = $wireModel;
        $this->size = $size;
        $this->class = $class;
        $this->help = $help;
        $this->required = $required;
        $this->requiredIcon = $requiredIcon;
    }

    /**
     * @return \Closure|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        return view('wiretable::components.fields.layout-field');
    }
}
