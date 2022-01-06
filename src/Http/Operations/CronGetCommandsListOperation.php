<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Operations;

use Illuminate\Support\Collection;
use OZiTAG\Tager\Backend\Core\Jobs\Operation;
use OZiTAG\Tager\Backend\Cron\Http\Jobs\CronGetCommandsListJob;
use OZiTAG\Tager\Backend\Cron\Http\Jobs\CronMapCommandJob;

class CronGetCommandsListOperation extends Operation
{
    public function __construct(
        private ?string $signature = null,
        private ?string $query = null,
    ) { }

    public function handle() {
        /** @var Collection $commands_raw_list */
        $commands_raw_list = $this->run(CronGetCommandsListJob::class);

        return $commands_raw_list
            ->filter(fn ($command) => $this->query
                ? (strpos(strtolower($command->getSignature()), $this->query) !== false)
                     || (strpos(strtolower($command->getDescription()), $this->query) !== false)
                : true
            )
            ->filter(fn ($command) => $this->signature
                ? $this->signature === $command->getSignature()
                : true
            )
            ->map(fn ($command) => $this->run(CronMapCommandJob::class, [
                'command' => $command
            ]));
    }
}
