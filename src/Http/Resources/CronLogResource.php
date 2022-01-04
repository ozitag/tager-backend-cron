<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Resources;

use OZiTAG\Tager\Backend\Core\Resources\JsonResource;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandDto;

class CronLogResource extends CronLogShortResource
{
    public function getData() {
        return array_merge(parent::getData(), [
            'output' => $this->output,
            'class' => $this->class,
            'error' => $this->error,
        ]);
    }
}
