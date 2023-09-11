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

        $paramName = $param->getName();
        if(str_ends_with($paramName, '?')){
            $paramName = mb_substr($paramName, 0, -1);
            $isOptional = true;
        } else{
            $isOptional = false;
        }

        return [
            'name' => $paramName,
            'optional' => $isOptional,
            'default' => $param->getDefault(),
            'values' => $param->getValues(),
            'method' => $param->getMethod(),
            'description' => $param->getDescription(),
        ];
    }
}
