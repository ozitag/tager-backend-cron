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
            'default' => $param->getDefault(),
            'values' => $param->getValues(),
            'method' => $param->getMethod(),
            'description' => $param->getDescription(),
        ];
    }
}
