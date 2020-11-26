<?php

namespace Sashalenz\Wiretable;

use Illuminate\Support\Collection;

interface Fields
{
    public function __invoke(): Collection;
}
