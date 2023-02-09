<?php

namespace OZiTAG\Tager\Backend\Cron\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use OZiTAG\Tager\Backend\Admin\Models\Administrator;
use OZiTAG\Tager\Backend\Core\Models\TModel;

/**
 * @property int id
 *
 * @property Administrator administrator
 */
class TagerCommandLog extends TModel
{
    protected $table = 'tager_commands_logs';

    protected array $filterable = ['signature'];

    static string $defaultOrder = 'id desc';

    protected $guarded = [];

    public function administrator()
    {
        return $this->belongsTo(Administrator::class, 'user_id');
    }
}
