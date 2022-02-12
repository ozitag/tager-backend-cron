<?php

namespace OZiTAG\Tager\Backend\Cron\Console;

use OZiTAG\Tager\Backend\Utils\Formatters\ExceptionFormatter;
use OZiTAG\Tager\Backend\Utils\Helpers\DateHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Facades\App;
use OZiTAG\Tager\Backend\Core\Console\Command;
use OZiTAG\Tager\Backend\Cron\Enums\CronJobStatus;
use OZiTAG\Tager\Backend\Cron\Models\TagerCronJob;
use OZiTAG\Tager\Backend\Cron\Repositories\TagerCronJobRepository;

abstract class CronCommand extends Command
{
    abstract function handle();

    /** @var TagerCronJobRepository */
    private $cronJobRepository;

    /** @var TagerCronJob */
    private $model;

    protected $logSavePortion = 100;

    protected bool $saveOutputToDatabase = false;

    public function __construct()
    {
        parent::__construct();

        $this->cronJobRepository = App::make(TagerCronJobRepository::class);

        $this->setLogCallback([$this, 'onSaveLog']);
    }

    protected function onSaveLog($log)
    {
        if ($this->saveOutputToDatabase) {
            $this->cronJobRepository->update([
                'output' => $log
            ]);
        }
    }

    private function getCommand()
    {
        $argv = isset($_SERVER['argv']) ? $_SERVER['argv'] : [];
        return implode(' ', array_merge(['php'], $argv));
    }

    private function onStart()
    {
        $this->model = $this->cronJobRepository->fillAndSave([
            'class' => static::class,
            'command' => $this->getCommand(),
            'status' => CronJobStatus::Started->value,
            'begin_at' => DateHelper::getDbDateTime()
        ]);

        $this->cronJobRepository->set($this->model);
    }

    private function onEnd()
    {
        $this->cronJobRepository->update([
            'status' => CronJobStatus::Completed->value,
            'end_at' => DateHelper::getDbDateTime(),
            'output' => $this->saveOutputToDatabase ? $this->log : null
        ]);
    }

    private function onError(\Throwable $exception)
    {
        $this->cronJobRepository->update([
            'status' => CronJobStatus::Failed->value,
            'end_at' => DateHelper::getDbDateTime(),
            'output' => $this->saveOutputToDatabase ? $this->log : null,
            'error' => ExceptionFormatter::getFullExceptionInfo($exception)
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
        } catch (\Throwable $exception) {
            $this->onError($exception);
            throw $exception;
        }
    }
}
