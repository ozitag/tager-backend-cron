<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Operations;

use OZiTAG\Tager\Backend\Core\Jobs\Operation;
use OZiTAG\Tager\Backend\Cron\Http\Jobs\CronGetCommandsListJob;
use OZiTAG\Tager\Backend\Cron\Http\Jobs\CronMapCommandJob;

class CronGetCommandsListOperation extends Operation
{
    public function handle() {
        $commands_raw_list = $this->run(CronGetCommandsListJob::class);

        return array_map(fn ($command) => $this->run(CronMapCommandJob::class, [
            'command' => $command
        ]), $commands_raw_list);
    }
}
