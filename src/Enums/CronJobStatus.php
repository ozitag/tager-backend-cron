<?php

namespace OZiTAG\Tager\Backend\Cron\Enums;

use OZiTAG\Tager\Backend\Core\Enums\Enum;

class CronJobStatus extends Enum
{
    const Started = 'STARTED';
    const Completed = 'COMPLETED';
    const Failed = 'FAILED';
}
