<?php

use Illuminate\Support\Facades\Route;
use OZiTAG\Tager\Backend\Cron\Controllers\AdminLogsController;
use \OZiTAG\Tager\Backend\Cron\Controllers\CommandsController;

Route::group(['prefix' => 'admin', 'middleware' => ['passport:administrators', 'auth:api']], function () {
    Route::get('/cron/logs', [AdminLogsController::class, 'index']);

    Route::group(['prefix' => 'cron/commands'], function () {
        Route::get('/', [CommandsController::class, 'list']);
        Route::post('/execute', [CommandsController::class, 'execute']);
        Route::post('/common-data', [CommandsController::class, 'common']);
    });

});
