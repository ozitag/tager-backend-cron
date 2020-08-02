<?php

namespace OZiTAG\Tager\Backend\Cron\Repositories;

use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Cron\Models\TagerCronJob;

class TagerCronJobRepository extends EloquentRepository
{
    public function __construct(TagerCronJob $model)
    {
        parent::__construct($model);
    }
}
