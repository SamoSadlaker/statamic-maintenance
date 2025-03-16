<?php

namespace SamoSadlaker\StatamicMaintenance;

use SamoSadlaker\StatamicMaintenance\Http\Middleware\MaintenanceMiddleware;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Facades\CP\Nav;

class ServiceProvider extends AddonServiceProvider
{

    protected $routes = [
        'cp' => __DIR__ . '/../routes/cp.php',
        'web' => __DIR__ . '/../routes/web.php',
    ];

    protected $middlewareGroups = [
        'web' => [
            MaintenanceMiddleware::class
        ],
    ];
    public function bootAddon()
    {
        parent::boot();

        Nav::extend(function ($nav) {
            $nav->create('Maintenance')
                ->section('Tools')
                ->route('samosadlaker.maintenance.index')
                ->icon('shield-key');
        });

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/statamic-maintenance'),
        ], 'statamic-maintenance-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'statamic-maintenance');
    }

}
