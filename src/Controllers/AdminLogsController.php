<?php

namespace OZiTAG\Tager\Backend\Cron\Controllers;

use OZiTAG\Tager\Backend\Cron\Http\Resources\CronLogResource;
use OZiTAG\Tager\Backend\Cron\Http\Resources\CronLogShortResource;
use OZiTAG\Tager\Backend\Cron\Repositories\TagerCronJobRepository;
use OZiTAG\Tager\Backend\Crud\Controllers\CrudController;

class AdminLogsController extends CrudController
{
    protected bool $hasIndexAction = true;

    protected bool $hasViewAction = true;

    protected bool $hasStoreAction = false;

    protected bool $hasUpdateAction = false;

    protected bool $hasDeleteAction = false;

    protected bool $hasMoveAction = false;

    public function __construct(TagerCronJobRepository $repository)
    {
        parent::__construct($repository);

        $this->setResourceFields([
            'id',
            'command',
            'class',
            'status',
            'begin_at:datetime',
            'end_at:datetime',
            'output',
            'error'
        ]);

        $this->setShortResourceClass(CronLogShortResource::class);
        $this->setFullResourceClass(CronLogResource::class);
    }

}
