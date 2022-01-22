<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Jobs;

use Illuminate\Support\Facades\Artisan;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Cron\Enums\CronCommandsStatus;
use OZiTAG\Tager\Backend\Cron\Repositories\TagerCommandLogRepository;

class CronUpdateCommandLogJob extends Job
{
    public function __construct(
        private int                $log_id,
        private CronCommandsStatus $status,
        private ?string            $output,
        private ?float             $microtime,
    )
    {
    }

    public function handle(TagerCommandLogRepository $repository): ?int
    {
        $repository->setById($this->log_id);

        try {
            return $repository->fillAndSave([
                    'output' => $this->output,
                    'status' => $this->status->value,
                    'execution_time' => $this->microtime,
                ])->id ?? null;
        } catch (\Exception $exception) {

        }
    }
}
