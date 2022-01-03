<?php

namespace OZiTAG\Tager\Backend\Cron\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use OZiTAG\Tager\Backend\Admin\Models\Administrator;
use OZiTAG\Tager\Backend\Core\Models\TModel;

/**
 * Class TagerCommandLog
 * @property int id
 * @property Administrator administrator
 */
class TagerCommandLog extends TModel
{
    protected $table = 'tager_commands_logs';

    protected array $filterable = ['signature'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function administrator()
    {
        return $this->belongsTo(Administrator::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }
}
