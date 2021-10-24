<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Resources;

use OZiTAG\Tager\Backend\Core\Resources\JsonResource;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandDto;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandParamDto;

class CronWebCommandParamResource extends JsonResource
{
    public function getData() {
        /** @var WebCommandParamDto $param */
        $param = $this->resource;
        return [
            'name' => $param->getName(),
            'default' => !$param->getFunction()
                ? $param->getDefault()
                : null,
            'values' => $param->getValues(),
            'function' => $param->getFunction(),
            'description' => $param->getDescription(),
        ];
    }
}
