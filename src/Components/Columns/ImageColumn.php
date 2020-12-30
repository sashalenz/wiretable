<?php

namespace Sashalenz\Wiretable\Components\Columns;

class ImageColumn extends Column
{
    public function render()
    {
        return view('wiretable::components.columns.image-column');
    }
}
