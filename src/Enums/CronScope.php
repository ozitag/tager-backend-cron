<?php

namespace OZiTAG\Tager\Backend\Cron\Enums;

enum CronScope: string
{
    case Commands = 'tager-cron.commands';
    case Cron = 'tager-cron.cron';
}
