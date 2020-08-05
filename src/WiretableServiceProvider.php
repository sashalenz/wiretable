<?php

namespace Sashalenz\Wiretable;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sashalenz\Wiretable\Components\Alert;
use Sashalenz\Wiretable\Components\Fields\SelectField;
use Sashalenz\Wiretable\Components\Fields\TextField;
use Sashalenz\Wiretable\Components\Form;
use Sashalenz\Wiretable\Components\Modal;
use Sashalenz\Wiretable\Components\Table;
use Sashalenz\Wiretable\Livewire\ModelSearch;

class WiretableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'wiretable');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'wiretable');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/resources/views' => $this->app->resourcePath('views/vendor/wiretable'),
            ], 'views');

            $this->publishes([
                __DIR__.'/resources/js' => public_path('vendor/wiretable'),
            ], 'views');

            $this->publishes([
                __DIR__.'/resources/lang' => $this->app->resourcePath('lang/vendor/wiretable'),
            ], 'translation');
        }

        $this->loadViewComponentsAs('wiretable', [
            Table::class,
            Modal::class,
            Form::class,
            Alert::class,
            TextField::class,
            SelectField::class
        ]);

        Livewire::component('model-search', ModelSearch::class);
    }

    public function register(): void
    {
//
    }
}
