<?php

namespace OZiTAG\Tager\Backend\Cron\Controllers;

use OZiTAG\Tager\Backend\Cron\Repositories\TagerCronJobRepository;
use OZiTAG\Tager\Backend\Crud\Controllers\CrudController;

class AdminLogsController extends CrudController
{
    protected $hasIndexAction = true;

    protected $hasViewAction = false;

    protected $hasStoreAction = false;

    protected $hasUpdateAction = false;

    protected $hasDeleteAction = false;

    protected $hasMoveAction = false;

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
    }

}
