<?php

namespace OZiTAG\Tager\Backend\Cron\Listeners;

use Illuminate\Contracts\Bus\Dispatcher;
use OZiTAG\Tager\Backend\Cron\Enums\CronCommandsStatus;
use OZiTAG\Tager\Backend\Cron\Events\TagerCommandFailed;
use OZiTAG\Tager\Backend\Cron\Events\TagerCommandFinished;
use OZiTAG\Tager\Backend\Cron\Http\Jobs\CronUpdateCommandLogJob;

class TagerCommandFinishedListener
{
    public function handle(TagerCommandFinished $event)
    {
        app(Dispatcher::class)->dispatchNow(
            new CronUpdateCommandLogJob(
                $event->getCommandId(),
                $event instanceof TagerCommandFailed
                    ? CronCommandsStatus::Failed
                    : CronCommandsStatus::Finished,
                $event->getOutput(),
                $event->getMicrotime(),
            )
        );

    }
}
