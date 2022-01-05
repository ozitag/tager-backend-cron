<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Resources;

use OZiTAG\Tager\Backend\Core\Resources\JsonResource;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandDto;

class CronCommandLogShortResource extends JsonResource
{
    public function getData() {
        return [
            'id' => $this->id,
            'signature' => $this->signature,
            'arguments' => $this->arguments
                ? json_decode($this->arguments)
                : [],
            'created_at' => $this->created_at,
            'user' => $this->user_id ? [
                'id' => $this->user_id,
                'name' => $this->administrator->name ?? ''
            ] : null,
            'execution_time' => $this->execution_time,
            'status' => strtoupper($this->status),
            'hasoutput' => !!$this->output,
        ];
    }
}
