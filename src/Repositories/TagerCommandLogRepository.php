<?php

namespace OZiTAG\Tager\Backend\Cron\Repositories;

use Illuminate\Database\Eloquent\Builder;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Cron\Models\TagerCommandLog;
use OZiTAG\Tager\Backend\Core\Repositories\IFilterable;
use OZiTAG\Tager\Backend\Core\Repositories\ISearchable;

class TagerCommandLogRepository extends EloquentRepository implements ISearchable, IFilterable
{
    public function __construct(TagerCommandLog $model)
    {
        parent::__construct($model);
    }

    public function filterByKey(Builder $builder, string $key, mixed $value): Builder
    {
        switch ($key) {
            case 'signature':
                $builder->where('signature', $value);
        }
        return $builder;
    }

    public function searchByQuery(?string $query, Builder $builder = null): ?Builder
    {
        $builder = $builder ? $builder : $this->model;
        return $builder->where('signature', 'LIKE', "%$query%")->orWhere('output', 'LIKE', "%$query%");
    }
}
