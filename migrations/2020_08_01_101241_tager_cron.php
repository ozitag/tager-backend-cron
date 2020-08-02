<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TagerCron extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tager_cron_jobs', function (Blueprint $table) {
            $table->id();

            $table->string('class_name');
            $table->string('signature');
            $table->string('status');
            $table->dateTime('begin_at');
            $table->dateTime('end_at')->nullable();
            $table->longText('output')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tager_cron_jobs');
    }
}
