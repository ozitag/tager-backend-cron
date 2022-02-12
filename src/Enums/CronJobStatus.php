<?php

namespace OZiTAG\Tager\Backend\Cron\Enums;

enum CronJobStatus: string
{
    case Started = 'STARTED';
    case Completed = 'COMPLETED';
    case Failed = 'FAILED';
}
