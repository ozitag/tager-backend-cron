<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Features;

use OZiTAG\Tager\Backend\Core\Console\Command;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandDto;
use OZiTAG\Tager\Backend\Cron\Http\Operations\CronGetCommandClassOperation;
use OZiTAG\Tager\Backend\Cron\Http\Operations\CronGetCommandOperation;
use OZiTAG\Tager\Backend\Cron\Http\Requests\CommandCommandDataRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CronGetCommandCommonDataFeature extends Feature
{
    public function handle(CommandCommandDataRequest $request) {
        /** @var ?Command $command */
        $command = $this->run(CronGetCommandClassOperation::class, [
            'command' => $request->get('command'),
        ]);

        if (!$command) {
            throw new HttpException(404, 'Command Not Found!');
        }

        return $command->executeHelpMethod(
            $request->get('method'),
            array_merge(
                ...array_map(fn($i) => [$i['name'] => $i['value']],
                    $request->get('arguments'))
            )
        );
    }
}
