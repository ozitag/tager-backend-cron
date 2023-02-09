<?php

namespace OZiTAG\Tager\Backend\Cron\Repositories;

use Illuminate\Contracts\Database\Eloquent\Builder;
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
                $builder->where('signature', '=', $value);
                break;
            case 'status':
                $builder->whereIn('status', explode(',', strtoupper($value)));
                break;
            case 'date-from':
                $builder->where('created_at', '>=', $value);
                break;
            case 'date-to':
                $builder->where('created_at', '<=' , $value);
                break;
        }
        return $builder;
    }

    public function searchByQuery(?string $query, Builder $builder = null): ?Builder
    {
        $builder = $builder ? $builder : $this->model;
        return $builder->where('signature', 'LIKE', "%$query%")->orWhere('output', 'LIKE', "%$query%");
    }
}
