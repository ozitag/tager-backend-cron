<?php

namespace OZiTAG\Tager\Backend\Cron\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TagerCronJob extends Model
{
    public $timestamps = false;

    protected $table = 'tager_cron_jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class',
        'command',
        'status',
        'begin_at',
        'end_at',
        'output',
        'error'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('begin_at', 'desc');
        });
    }
}
