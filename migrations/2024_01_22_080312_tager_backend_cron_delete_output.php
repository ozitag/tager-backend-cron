<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TagerBackendCronDeleteOutput extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tager_cron_jobs', function (Blueprint $table) {
            $table->dropColumn('output');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tager_cron_jobs', function (Blueprint $table) {
            $table->longText('output')->nullable()->change();
        });
    }
}
