<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Jobs;

use Illuminate\Support\Facades\Artisan;
use OZiTAG\Tager\Backend\Core\Jobs\Job;

class CronExecuteCommandJob extends Job
{
    public function __construct(
        private string $command,
        private array $params
    ) {}

    public function handle(): ?string {
        try {
            ob_start();
            Artisan::call($this->command, $this->params);
        } catch (\Throwable $throwable) {
            echo "<br />Some error occured: " . $throwable->getMessage();
        }

        return ob_get_clean();
    }
}
