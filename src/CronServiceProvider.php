<?php

namespace OZiTAG\Tager\Backend\Cron;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\ServiceProvider;
use OZiTAG\Tager\Backend\Core\Console\Command;
use OZiTAG\Tager\Backend\Cron\Console\CommandMixin;
use OZiTAG\Tager\Backend\Cron\Enums\CronScope;
use OZiTAG\Tager\Backend\Cron\Events\TagerCommandFailed;
use OZiTAG\Tager\Backend\Cron\Events\TagerCommandFinished;
use OZiTAG\Tager\Backend\Cron\Listeners\TagerCommandFinishedListener;
use OZiTAG\Tager\Backend\Rbac\TagerScopes;

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
        
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'tager-cron');

        TagerScopes::registerGroup(__('tager-cron::scopes.group'), [
            CronScope::COMMANDS->value => __('tager-cron::scopes.commands_list'),
            CronScope::COMMAND_EXEC->value => __('tager-cron::scopes.command_execute'),
            CronScope::COMMANDS_LOGS->value => __('tager-cron::scopes.commands_logs'),
            CronScope::COMMANDS_LOGS_DETAILS->value => __('tager-cron::scopes.command_log_details'),
            CronScope::CRON_LOGS->value => __('tager-cron::scopes.cron_logs'),
            CronScope::CRON_LOGS_DETAILS->value => __('tager-cron::scopes.cron_log_details'),
        ]);
        
        Command::mixin(new CommandMixin());
    }
}
