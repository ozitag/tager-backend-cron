<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Features;

use Illuminate\Console\BufferedConsoleOutput;
use Illuminate\Support\Facades\Artisan;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandDto;
use OZiTAG\Tager\Backend\Cron\Http\Jobs\CronExecuteCommandJob;
use OZiTAG\Tager\Backend\Cron\Http\Jobs\CronSaveCommandLogJob;
use OZiTAG\Tager\Backend\Cron\Http\Operations\CronGetCommandOperation;
use OZiTAG\Tager\Backend\Cron\Http\Operations\CronPrepareCommandParamsOperation;
use OZiTAG\Tager\Backend\Cron\Http\Requests\CommandExecuteRequest;
use OZiTAG\Tager\Backend\Cron\Http\Resources\CronWebCommandContentResource;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExecuteCommandFeature extends Feature
{
    public function handle(CommandExecuteRequest $request) {
        /** @var ?WebCommandDto $command */
        $command = $this->run(CronGetCommandOperation::class, [
            'command' => $request->get('command'),
        ]);

        if (!$command) {
            throw new HttpException(404, 'Command Not Found!');
        }

        $params = $this->run(CronPrepareCommandParamsOperation::class, [
            'command' => $command,
            'params' => $request->get('arguments', []),
        ]);
        
        $log_id = $this->run(CronSaveCommandLogJob::class, [
            'command' => $command->getSignature(),
            'params' => $params,
            'user_id' => $this->user()->id
        ]);

        $content = $this->run(CronExecuteCommandJob::class, [
            'command' => $command->getSignature(),
            'params' => $params,
            'log_id' => $log_id,
        ]);

        return new CronWebCommandContentResource($content);
    }
}
