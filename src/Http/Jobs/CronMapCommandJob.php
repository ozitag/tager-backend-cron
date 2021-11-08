<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Jobs;

use Illuminate\Console\Command;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Cron\Dto\CommandParamDto;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandDto;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandParamDto;

class CronMapCommandJob extends Job
{
    public function __construct(
        protected Command $command
    ) { }

    public function handle() {
        /** @var array<CommandParamDto> $params */
        $params = $this->command->getParams();

        foreach ($params as &$param) {
            $values = $this->getValues($param);
            $param = new WebCommandParamDto(
                $param->getName(),
                $values,
                $this->getDefaultValue((bool) $values, $param),
                $this->getMethod((bool) $values, $param),
                $this->getDescription((bool) $values, $param),
            );
        }

        return new WebCommandDto(
            $this->command->getSignature(), $params,
        );
    }

    protected function getDefaultValue(bool $values_exists, CommandParamDto $param): ?string {
        if ($values_exists) {
            return null;
        }
        return $param->getDefaultValue();
    }


    protected function getMethod(bool $values_exists, CommandParamDto $param): ?string {
        if ($values_exists) {
            return null;
        }
        $value = $param->getDefaultValue();

        if (!$value) {
            return null;
        }

        preg_match('/fn\[(\w+)\]/', $value, $matches);
        return $matches[1] ?? null;
    }


    protected function getDescription(bool $values_exists, CommandParamDto $param): ?string {
        if ($values_exists) {
            return null;
        }
        $value = $param->getOriginalName();

        if (!$value) {
            return null;
        }

        preg_match('/:((\w|\s|\d)+)=?/', $value, $matches);
        return $matches[1] ?? null;
    }

    protected function getValues(CommandParamDto $param): array {
        $default_value = $param->getDefaultValue();
        if (!$default_value) {
            return [];
        }

        $parts = explode('||', $default_value);

        if (count($parts) < 2) {
            return [];
        }

        return $parts;
    }
}
