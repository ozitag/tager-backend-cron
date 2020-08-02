<?php

namespace OZiTAG\Tager\Backend\Cron\Console;

use Illuminate\Console\Command;
use OZiTAG\Tager\Backend\Cron\Enums\CronJobStatus;
use OZiTAG\Tager\Backend\Cron\Models\TagerCronJob;
use OZiTAG\Tager\Backend\Cron\Repositories\TagerCronJobRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class CronCommand extends Command
{
    abstract function handle();

    /** @var TagerCronJobRepository */
    private $cronJobRepository;

    /** @var TagerCronJob */
    private $model;

    public function __construct(TagerCronJobRepository $cronJobRepository)
    {
        parent::__construct();

        $this->cronJobRepository = $cronJobRepository;
    }

    private function getConsoleOutput()
    {
        $log = ob_get_contents();
        @ob_end_flush();
        return $log;
    }

    private function onStart()
    {
        ob_start();

        $this->model = $this->cronJobRepository->fillAndSave([
            'class_name' => static::class,
            'signature' => $this->signature,
            'status' => CronJobStatus::Started,
            'begin_at' => date('Y-m-d H:i:s')
        ]);

        $this->cronJobRepository->set($this->model);
    }

    private function onEnd()
    {
        $this->cronJobRepository->update([
            'status' => CronJobStatus::Completed,
            'end_at' => date('Y-m-d H:i:s'),
            'output' => $this->getConsoleOutput()
        ]);
    }

    private function onError(\Exception $exception)
    {
        $this->cronJobRepository->update([
            'status' => CronJobStatus::Failed,
            'end_at' => date('Y-m-d H:i:s'),
            'output' => $this->getConsoleOutput(),
            'error' => (string)$exception
        ]);
    }

    /**
     * Execute the console command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return (int)$this->laravel->call([$this, 'process']);
    }

    public function process()
    {
        $this->onStart();

        try {
            $this->handle();
            $this->onEnd();
        } catch (\Exception $exception) {
            $this->onError($exception);
        }
    }
}
