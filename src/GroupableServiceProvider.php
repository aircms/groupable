<?php

namespace aircms\groupable;

use App\Job;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class GroupableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->publishes([__DIR__ . '/Config/groupable.php' => config_path('groupable.php')], 'groupable');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/groupable.php', 'groupable');

        $morphItems = collect(Config::get('groupable.models', []))->map(function ($modelClass) {
            $tableName = (new $modelClass)->getTable();
            return [$tableName => $modelClass];
        })->flatMap(function ($item) {
            return $item;
        })->all();

        Relation::morphMap($morphItems);
    }
}
