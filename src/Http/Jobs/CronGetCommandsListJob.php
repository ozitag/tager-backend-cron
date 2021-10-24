<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Jobs;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Cron\Console\Contracts\IConsoleOnlyExecutable;
use OZiTAG\Tager\Backend\Cron\Console\Contracts\IWebExecutable;
use \Illuminate\Console\Command;
use \OZiTAG\Tager\Backend\Core\Console\Command as TagerCommand;

class CronGetCommandsListJob extends Job
{
    public function handle() {
        $web_execute_available = (bool) Config::get('tager-cron.web_executing.enabled');
        $only_tager_commands = (bool) Config::get('tager-cron.web_executing.only_tager_commands');

        $commands = [];
        $commands_list = Artisan::all();

        foreach ($commands_list as $command) {
            
            if ($only_tager_commands) {
                if (!($command instanceof TagerCommand)) {
                    continue;
                }
            } else {
                if (!($command instanceof Command)) {
                    continue;
                }
            }

            if ($command instanceof IConsoleOnlyExecutable) {
                continue;
            }

            if (!$command->getSignature()) {
                continue;
            }

            if ($web_execute_available || $command instanceof IWebExecutable) {
                $commands [] = $command;
            }
        }

        return $commands;
    }
}
