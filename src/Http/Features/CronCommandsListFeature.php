<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Features;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Cron\Http\Resources\CronCommandResource;
use OZiTAG\Tager\Backend\Cron\Repositories\TagerCronJobRepository;

class CronCommandsListFeature extends Feature
{
    public function handle(TagerCronJobRepository $repository) {
        $commands = $repository->getCommandsForSearch();
        
        return CronCommandResource::collection($commands);
    }
}
