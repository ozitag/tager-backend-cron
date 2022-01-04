<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Resources;

use OZiTAG\Tager\Backend\Core\Resources\JsonResource;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandDto;

class CronLogResource extends CronLogShortResource
{
    public function getData() {
        return array_merge(parent::getData(), [
            'command' => $this->command,
            'output' => $this->output,
            'error' => $this->error,
        ]);
    }
}
