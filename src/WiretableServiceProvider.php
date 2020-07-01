<?php

namespace Sashalenz\Wiretable;

use Illuminate\Support\ServiceProvider;
use Sashalenz\Wiretable\Components\Inputs\SelectInput;
use Sashalenz\Wiretable\Components\Inputs\SwitchInput;
use Sashalenz\Wiretable\Components\Inputs\TextFilter;
use Sashalenz\Wiretable\Components\Table;

class WiretableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'wiretable');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/resources/views' => $this->app->resourcePath('views/vendor/wiretable'),
            ], 'wiretable');
        }

        $this->loadViewComponentsAs('wiretable', [
            Table::class
        ]);
    }

    public function register(): void
    {
//
    }
}
