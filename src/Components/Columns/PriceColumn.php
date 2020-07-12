<?php

namespace Sashalenz\Wiretable\Components\Columns;

use Illuminate\View\View;

class PriceColumn extends Column
{
    public string $currency = 'EUR';

    /**
     * @param string $currency
     * @return $this
     */
    public function currency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrencySymbol(): string
    {
        $symbols = [
            'UAH' => 'far fa-hryvnia',
            'EUR' => 'far fa-euro-sign',
            'USD' => 'far fa-dollar-sign'
        ];

        return $symbols[$this->currency] ?? null;
    }

    /**
     * @param $row
     * @return View|mixed|string
     */
    public function renderIt($row)
    {
        return $this->getValue($row) . ' <i class="'. $this->getCurrencySymbol() .'"></i>';
    }

    /**
     * @return View|null
     */
    public function render():? View
    {
        return null;
    }
}
