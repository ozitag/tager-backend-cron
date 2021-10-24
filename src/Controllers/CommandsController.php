<?php

namespace OZiTAG\Tager\Backend\Cron\Controllers;

use OZiTAG\Tager\Backend\Core\Controllers\Controller;
use OZiTAG\Tager\Backend\Cron\Http\Features\CronCommandsListFeature;
use OZiTAG\Tager\Backend\Cron\Http\Features\CronExecuteCommandFeature;
use OZiTAG\Tager\Backend\Cron\Http\Features\CronGetCommandCommonDataFeature;
use OZiTAG\Tager\Backend\Crud\Controllers\CrudController;

class CommandsController extends Controller
{
    public function list() {
        return $this->serve(CronCommandsListFeature::class);
    }

    public function execute() {
        return $this->serve(CronExecuteCommandFeature::class);
    }

    public function common() {
        return $this->serve(CronGetCommandCommonDataFeature::class);
    }
}
