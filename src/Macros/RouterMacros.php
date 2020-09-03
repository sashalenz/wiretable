<?php

namespace Sashalenz\Wiretable\Macros;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouterMacros
{
    public function wirecrud(): callable
    {
        return function (string $name, array $properties = []) {

            $routes = collect([
                'index' => [
                    'url' => '/',
                    'layout' => 'main'
                ],
                'create' => [
                    'url' => '/create',
                    'layout' => 'modal'
                ],
                'show' => [
                    'url' => '/{%s}',
                    'layout' => 'main'
                ],
                'edit' => [
                    'url' => '/{%s}/edit',
                    'layout' => 'modal'
                ],
            ]);

            $filteredRoutes = $routes->when(
                isset($properties['only']),
                fn (Collection $row) => $row->filter(
                    fn ($route, $key) => in_array($key, $properties['only'], true)
                )
            );

            Route::prefix(Str::kebab($name))
                ->name(sprintf('%s.', $name))
                ->group(function () use ($name, $filteredRoutes) {
                    $group = $this->getGroupStack();

                    $component = Str::replaceFirst($group[0]['as'], '', last($group)['as']);
                    $component = Str::replaceLast($name, Str::kebab($name), $component);

                    foreach($filteredRoutes as $key => $route) {
                        $this->livewire(sprintf($route['url'], Str::singular($name)), $component.$key)
                            ->name($key)
                            ->layout($route['layout']);

                    }
                });
        };
    }
}
