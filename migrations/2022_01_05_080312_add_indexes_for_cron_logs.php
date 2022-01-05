<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesForCronLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::commit();
        $sql = <<<EOD
            ALTER TABLE tager_cron_jobs ADD INDEX tager_cron_jobs_status__index (status), ALGORITHM=INPLACE, LOCK=NONE;
EOD;
        DB::statement($sql);
        DB::commit();
        $sql = <<<EOD
            ALTER TABLE tager_cron_jobs ADD INDEX tager_cron_jobs_command__index (command), ALGORITHM=INPLACE, LOCK=NONE;
EOD;
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
