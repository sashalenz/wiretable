<?php

namespace Sashalenz\Wiretable\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Component;
use Illuminate\View\View;

class Modal extends Component
{
    /**
     * Table constructor.
     */
    public function __construct()
    {
//
    }

    /**
     * @return Factory|View|string
     */
    public function render()
    {
        return view('wiretable::components.modal');
    }

}
