<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Resources;

use Carbon\Carbon;
use OZiTAG\Tager\Backend\Core\Resources\JsonResource;
use OZiTAG\Tager\Backend\Cron\Dto\WebCommandDto;

class CronLogShortResource extends JsonResource
{
    public function getData() {
        return [
            'id' => $this->id,
            'command' => $this->command,
            'status' => strtoupper($this->status),
            'begin_at' => $this->begin_at
                ? Carbon::parse($this->begin_at)->toIso8601ZuluString()
                : null,
            'end_at' => $this->end_at
                ? Carbon::parse($this->end_at)->toIso8601ZuluString()
                : null,
            'duration' => $this->duration,
            'hasoutput' => !!$this->output,
            'haserror' => !!$this->error,
        ];
    }
}
