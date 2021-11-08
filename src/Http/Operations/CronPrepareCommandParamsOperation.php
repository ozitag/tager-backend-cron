<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Operations;


use OZiTAG\Tager\Backend\Core\Jobs\Operation;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandDto;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandParamDto;

class CronPrepareCommandParamsOperation extends Operation
{
    public function __construct(
        private WebCommandDto $command,
        private array $params
    ) {}

    public function handle(): array {
        $params = [];
        $raw_params = array_merge(
            ...array_map(fn($i) => [$i['name'] => $i['value']],
                $this->params)
        );

        /** @var WebCommandParamDto $param */
        foreach ($this->command->getParams() as $param) {
            if (in_array($param->getName(), array_keys($raw_params))) {
                $params[$param->getName()] = $raw_params[$param->getName()] ?? null;
            }
        }

        return $params;
    }
}
