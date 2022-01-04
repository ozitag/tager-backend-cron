<?php

namespace OZiTAG\Tager\Backend\Cron\Enums;

enum CronScope: string
{
    case COMMANDS = 'COMMANDS';
    case COMMAND_EXEC = 'COMMAND_EXEC';
    case COMMANDS_LOGS = 'COMMANDS_LOGS';
    case COMMANDS_LOGS_DETAILS = 'COMMANDS_LOGS_DETAILS';
    case CRON_LOGS = 'CRON_LOGS';
    case CRON_LOGS_DETAILS = 'CRON_LOGS_DETAILS';
}
