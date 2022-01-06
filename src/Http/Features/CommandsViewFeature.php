<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Features;

use Illuminate\Support\Collection;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Cron\Http\Operations\CronGetCommandsListOperation;
use OZiTAG\Tager\Backend\Cron\Http\Resources\CronWebCommandResource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommandsViewFeature extends Feature
{
    public function __construct(
        private string $signature
    ) { }

    public function handle() {
        /** @var Collection $commands */
        $commands = $this->run(CronGetCommandsListOperation::class, [
            'signature' => $this->signature,
        ]);

        if (count($commands) < 1) {
            throw new NotFoundHttpException('Command Not Found!');
        }

        return new CronWebCommandResource($commands->shift());
    }
}
