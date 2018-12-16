<?php

namespace tkivelip\LaravelSqlExecuter\Providers;

use Illuminate\Support\ServiceProvider;
use tkivelip\LaravelSqlExecuter\Commands\QueueCommand;
use tkivelip\LaravelSqlExecuter\Commands\RunCommand;

class SqlExecuterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RunCommand::class,
                QueueCommand::class,
            ]);
        }
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
