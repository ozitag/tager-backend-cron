<?php

namespace OZiTAG\Tager\Backend\Cron;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\ServiceProvider;
use OZiTAG\Tager\Backend\Core\Console\Command;
use OZiTAG\Tager\Backend\Cron\Console\CommandMixin;
use OZiTAG\Tager\Backend\Cron\Events\TagerCommandFailed;
use OZiTAG\Tager\Backend\Cron\Events\TagerCommandFinished;
use OZiTAG\Tager\Backend\Cron\Listeners\TagerCommandFinishedListener;

class CronServiceProvider extends EventServiceProvider
{

    protected $listen = [
        TagerCommandFailed::class => [
            TagerCommandFinishedListener::class,
        ],
        TagerCommandFinished::class => [
            TagerCommandFinishedListener::class,
        ],
    ];


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
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
