<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Resources;

use OZiTAG\Tager\Backend\Core\Resources\JsonResource;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandDto;

class CronCommandResource extends JsonResource
{
    public function getData() {
        return [
            'value' => $this->value
        ];
    }
}
