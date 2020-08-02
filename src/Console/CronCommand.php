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

    /** @var string */
    private $log;

    /** @var int */
    protected $logSavePortion = 3;

    /** @var int */
    private $logNum = 0;

    public function __construct(TagerCronJobRepository $cronJobRepository)
    {
        parent::__construct();

        $this->cronJobRepository = $cronJobRepository;
    }

    private function onStart()
    {
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
            'output' => $this->log
        ]);
    }

    private function onError(\Exception $exception)
    {
        $this->cronJobRepository->update([
            'status' => CronJobStatus::Failed,
            'end_at' => date('Y-m-d H:i:s'),
            'output' => $this->log,
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

    protected function log($message)
    {
        $logMessage = date('d.m.Y H:i:s') . ' - ' . $message . "\n";
        echo $logMessage;

        $this->log .= $logMessage;

        $this->logNum = $this->logNum + 1;

        if ($this->logNum == $this->logSavePortion) {
            $this->cronJobRepository->update([
                'output' => $this->log
            ]);
            $this->logNum = 0;
        }
    }

}
