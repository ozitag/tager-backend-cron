<?php

namespace OZiTAG\Tager\Backend\Cron\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Core\Repositories\IFilterable;
use OZiTAG\Tager\Backend\Core\Repositories\ISearchable;
use OZiTAG\Tager\Backend\Cron\Models\TagerCronJob;

class TagerCronJobRepository extends EloquentRepository implements ISearchable, IFilterable
{
    public function __construct(TagerCronJob $model)
    {
        parent::__construct($model);
    }

    public function getCommandsForSearch(): array {
        return DB::select(<<<SQL
            SELECT command as value FROM tager_cron_jobs GROUP BY command
SQL );
    }

    public function filterByKey(Builder $builder, string $key, mixed $value): Builder
    {
        switch ($key) {
            case 'command':
                $builder->where('command', '=', $value);
                break;
            case 'status':
                $builder->whereIn('status', explode(',', strtolower($value)));
                break;
            case 'date-from':
                $builder->where('begin_at', '>=', $value);
                break;
            case 'date-to':
                $builder->where('end_at', '<=' , $value);
                break;
        }
        return $builder;
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
