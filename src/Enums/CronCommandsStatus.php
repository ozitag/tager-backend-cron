<?php

namespace OZiTAG\Tager\Backend\Cron\Enums;

enum CronCommandsStatus: string
{
    case Started = 'STARTED';
    case Finished = 'FINISHED';
    case Failed = 'FAILED';
}
