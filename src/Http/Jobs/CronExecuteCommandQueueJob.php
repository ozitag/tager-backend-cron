<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Jobs;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Core\Jobs\QueueJob;
use OZiTAG\Tager\Backend\Cron\Enums\CronCommandsStatus;
use OZiTAG\Tager\Backend\Cron\Events\TagerCommandFailed;
use OZiTAG\Tager\Backend\Cron\Events\TagerCommandFinished;
use OZiTAG\Tager\Backend\Cron\Repositories\TagerCommandLogRepository;

class CronExecuteCommandQueueJob extends QueueJob
{
    private $has_errors = false;
    private $started_time = false;

    public function __construct(
        private string $command,
        private array $params,
        private ?int $log_id,
    ) {
        $this->connection = config('tager-cron.queue.connection');
        parent::__construct();
    }

    public function handle(TagerCommandLogRepository $tagerCommandLogRepository): ?string {
        $tagerCommandLogRepository->setById($this->log_id)->fillAndSave([
            'status' => CronCommandsStatus::Started->value
        ]);

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
