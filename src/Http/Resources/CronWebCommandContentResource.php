<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Resources;

use OZiTAG\Tager\Backend\Core\Resources\JsonResource;

class CronWebCommandContentResource extends JsonResource
{
    public function getData() {
        return [
            'response' => $this->resource
        ];
    }
}
