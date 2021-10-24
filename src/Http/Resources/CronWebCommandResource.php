<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Resources;

use OZiTAG\Tager\Backend\Core\Resources\JsonResource;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandDto;

class CronWebCommandResource extends JsonResource
{
    public function getData() {
        /** @var WebCommandDto $command */
        $command = $this->resource;
        return [
            'signature' => $command->getSignature(),
            'params' => CronWebCommandParamResource::collection($command->getParams()),
        ];
    }
}
