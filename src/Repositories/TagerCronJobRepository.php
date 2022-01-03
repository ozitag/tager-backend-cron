<?php

namespace OZiTAG\Tager\Backend\Cron\Repositories;

use Illuminate\Database\Eloquent\Builder;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Core\Repositories\ISearchable;
use OZiTAG\Tager\Backend\Cron\Models\TagerCronJob;

class TagerCronJobRepository extends EloquentRepository implements ISearchable
{
    public function __construct(TagerCronJob $model)
    {
        parent::__construct($model);
    }

    public function searchByQuery(?string $query, Builder $builder = null): ?Builder
    {
        $builder = $builder ? $builder : $this->model;
        return $builder
            ->where('command', 'LIKE', "%$query%")
            ->where('class', 'LIKE', "%$query%")
            ->orWhere('output', 'LIKE', "%$query%")
            ->orWhere('error', 'LIKE', "%$query%");
    }
}
