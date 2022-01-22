<?php

use Illuminate\Support\Facades\Route;
use OZiTAG\Tager\Backend\Cron\Controllers\AdminLogsController;
use OZiTAG\Tager\Backend\Cron\Controllers\CommandsController;
use OZiTAG\Tager\Backend\Cron\Controllers\CommandsLogsController;
use OZiTAG\Tager\Backend\Rbac\Facades\AccessControlMiddleware;
use OZiTAG\Tager\Backend\Cron\Enums\CronScope;

Route::group(['prefix' => 'admin', 'middleware' => ['passport:administrators', 'auth:api']], function () {
    Route::group(['middleware' => [AccessControlMiddleware::scopes(CronScope::Cron->value)]], function () {
        Route::get('/cron/logs', [AdminLogsController::class, 'index']);
        Route::get('/cron/logs/commands', [AdminLogsController::class, 'commands']);
        Route::get('/cron/logs/{id}', [AdminLogsController::class, 'view']);
    });

    Route::group(['middleware' => [AccessControlMiddleware::scopes(CronScope::Commands->value)]], function () {
        Route::get('/cron/commands', [CommandsController::class, 'list']);
        Route::post('/cron/commands/execute', [CommandsController::class, 'execute']);
        Route::post('/cron/commands/common-data', [CommandsController::class, 'common']);
        Route::get('/cron/commands/logs', [CommandsLogsController::class, 'index']);
        Route::get('/cron/commands/logs/{id}', [CommandsLogsController::class, 'view']);
        Route::get('/cron/commands/{signature}', [CommandsController::class, 'view']);
    });
});
