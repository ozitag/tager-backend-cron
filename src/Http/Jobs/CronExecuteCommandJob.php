<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Jobs;

use Illuminate\Support\Facades\Artisan;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Cron\Events\TagerCommandFailed;
use OZiTAG\Tager\Backend\Cron\Events\TagerCommandFinished;

class CronExecuteCommandJob extends Job
{
    private $has_errors = false;
    private $started_time = false;

    public function __construct(
        private string $command,
        private array $params,
        private ?int $log_id,
    ) {}

    public function handle(): ?string {
        $response = $this->exec();

        if ($this->has_errors) {
            $this->log_id && event(new TagerCommandFailed(
                $this->log_id, $response, microtime(true) - $this->started_time,
            ));
        } else {
            $this->log_id && event(new TagerCommandFinished(
                $this->log_id, $response, microtime(true) - $this->started_time,
            ));
        }

        return $response;
    }

    private function exec(): ?string {
        $this->started_time = microtime(true);
        try {
            ob_start();
            Artisan::call($this->command, $this->params);
        } catch (\Throwable $throwable) {
            $this->has_errors = true;
            echo "<br />Some error occured: " . $throwable->getMessage();
        }

        return ob_get_clean();
    }
}
