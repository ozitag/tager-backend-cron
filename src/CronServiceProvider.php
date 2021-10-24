<?php

namespace OZiTAG\Tager\Backend\Cron;

use Illuminate\Support\ServiceProvider;
use OZiTAG\Tager\Backend\Core\Console\Command;
use OZiTAG\Tager\Backend\Cron\Console\CommandMixin;

class CronServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'tager-cron');

        Command::mixin(new CommandMixin());
    }
}
