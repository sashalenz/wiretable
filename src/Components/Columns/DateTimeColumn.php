<?php

namespace Sashalenz\Wiretable\Components\Columns;

use Carbon\Carbon;
use Illuminate\View\View;

class DateTimeColumn extends Column
{
    public string $format = 'Y-m-d H:i';

    public function __construct($name)
    {
        parent::__construct($name);
        $this->class('whitespace-nowrap text-gray-500');
    }

    /**
     * @param string $format
     * @return $this
     */
    public function format(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @param $row
     * @return View|mixed|string
     */
    public function renderIt($row)
    {
        $date = $row->{$this->getName()};

        if (is_string($date) || !($date instanceof Carbon)) {
            return $date;
        }

        return $date->format($this->format);
    }

    /**
     * @return View|null
     */
    public function render():? View
    {
        return null;
    }
}
