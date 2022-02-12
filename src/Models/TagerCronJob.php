<?php

namespace OZiTAG\Tager\Backend\Cron\Models;

use Illuminate\Database\Eloquent\Builder;
use OZiTAG\Tager\Backend\Core\Models\TModel;

/**
 * @property string $class
 * @property string $command
 * @property string $status
 * @property string $begin_at
 * @property string $end_at
 * @property string $output
 * @property string $error
 */
class TagerCronJob extends TModel
{
    public $timestamps = false;

    protected $table = 'tager_cron_jobs';

    protected array $filterable = ['command'];

    protected $fillable = [
        'class', 'command', 'status', 'begin_at', 'end_at', 'output', 'error'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('begin_at', 'desc');
        });
    }
}
