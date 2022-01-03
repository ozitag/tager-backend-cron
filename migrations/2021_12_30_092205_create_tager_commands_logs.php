<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagerCommandsLogs extends Migration
{
    public function up()
    {
        Schema::create('tager_commands_logs', function (Blueprint $table) {
            $table->id();
            $table->string('signature')->nullable()->index();
            $table->text('arguments')->nullable();
            $table->string('status')->nullable()->index();
            $table->text('output')->nullable();
            $table->integer('user_id')->nullable()->index();
            $table->float('execution_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cron_job_audits');
    }
}
