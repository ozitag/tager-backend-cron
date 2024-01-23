<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tager_cron_jobs', function (Blueprint $table) {
            $table->id();

            $table->string('command');
            $table->string('class')->nullable();
            $table->string('status');
            $table->dateTime('begin_at');
            $table->dateTime('end_at')->nullable();
            $table->longText('output')->nullable();
            $table->longText('error')->nullable();
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
};
