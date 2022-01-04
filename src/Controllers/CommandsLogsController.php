<?php

namespace OZiTAG\Tager\Backend\Cron\Controllers;

use OZiTAG\Tager\Backend\Cron\Http\Resources\CronCommandLogResource;
use OZiTAG\Tager\Backend\Cron\Http\Resources\CronCommandLogShortResource;
use OZiTAG\Tager\Backend\Cron\Repositories\TagerCommandLogRepository;
use OZiTAG\Tager\Backend\Crud\Controllers\CrudController;

class CommandsLogsController extends CrudController
{
    protected bool $hasIndexAction = true;

    protected bool $hasViewAction = true;
    protected bool $hasStoreAction = false;
    protected bool $hasUpdateAction = false;
    protected bool $hasDeleteAction = false;
    protected bool $hasMoveAction = false;

    public function __construct(TagerCommandLogRepository $repository)
    {
        parent::__construct($repository);

        $this->setShortResourceClass(CronCommandLogShortResource::class);
        $this->setFullResourceClass(CronCommandLogResource::class);
    }

}
