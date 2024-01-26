<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Jobs;

use Illuminate\Support\Facades\Artisan;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Cron\Enums\CronCommandsStatus;
use OZiTAG\Tager\Backend\Cron\Repositories\TagerCommandLogRepository;

class CronSaveCommandLogJob extends Job
{
    public function __construct(
        private string $command,
        private array $params,
        private int $user_id,
        private bool $async,
    ) {}

    public function handle(TagerCommandLogRepository $repository): ?int {
        return $repository->fillAndSave([
            'signature' => $this->command,
            'arguments' => json_encode($this->params),
            'user_id' => $this->user_id,
            'status' => $this->async ? CronCommandsStatus::Waiting->value : CronCommandsStatus::Started->value,
        ])->id ?? null;
    }
}
