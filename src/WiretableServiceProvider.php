<?php

namespace Sashalenz\Wiretable;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sashalenz\Wiretable\Components\Modal;
use Sashalenz\Wiretable\Components\Table;
use Sashalenz\Wiretable\Livewire\ModelSearch;

class WiretableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'wiretable');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/resources/views' => $this->app->resourcePath('views/vendor/wiretable'),
            ], 'views');

            $this->publishes([
                __DIR__.'/resources/js' => public_path('vendor/wiretable'),
            ], 'views');
        }

        $this->loadViewComponentsAs('wiretable', [
            Table::class,
            Modal::class
        ]);

        Livewire::component('model-search', ModelSearch::class);
    }

    public function register(): void
    {
//
    }
}
