<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Features;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Cron\Http\Operations\CronGetCommandsListOperation;
use OZiTAG\Tager\Backend\Cron\Http\Resources\CronWebCommandResource;

class CommandsListFeature extends Feature
{
    public function handle() {
        $commands = $this->run(CronGetCommandsListOperation::class);
        
        return CronWebCommandResource::collection($commands);
    }
}
