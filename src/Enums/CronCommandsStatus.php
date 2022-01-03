<?php

namespace OZiTAG\Tager\Backend\Cron\Enums;

enum CronCommandsStatus: string
{
    case STARTED = 'STARTED';
    case FINISHED = 'FINISHED';
    case FAILED = 'FAILED';
}
