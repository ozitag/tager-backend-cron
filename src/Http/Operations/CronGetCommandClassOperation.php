<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Operations;

use Illuminate\Support\Collection;
use OZiTAG\Tager\Backend\Core\Jobs\Operation;
use OZiTAG\Tager\Backend\Cron\Http\Jobs\CronGetCommandsListJob;
use OZiTAG\Tager\Backend\Cron\Http\Jobs\CronMapCommandJob;

class CronGetCommandClassOperation extends Operation
{
    public function __construct(private string $command) {}

    public function handle() {
        /** @var Collection $commands_raw_list */
        $commands_raw_list = $this->run(CronGetCommandsListJob::class);

        return $commands_raw_list->filter(
            fn ($command) => $command->getSignature() === $this->command
        )->first();
    }
}
