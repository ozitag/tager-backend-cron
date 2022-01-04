<?php

use Illuminate\Support\Facades\Route;
use OZiTAG\Tager\Backend\Cron\Controllers\AdminLogsController;
use \OZiTAG\Tager\Backend\Cron\Controllers\CommandsController;
use \OZiTAG\Tager\Backend\Cron\Controllers\CommandsLogsController;
use \OZiTAG\Tager\Backend\Rbac\Facades\AccessControlMiddleware;
use \OZiTAG\Tager\Backend\Cron\Enums\CronScope;

Route::group(['prefix' => 'admin', 'middleware' => ['passport:administrators', 'auth:api']], function () {
    Route::get('/cron/logs', [AdminLogsController::class, 'index'])
        ->middleware([
            AccessControlMiddleware::scopes(CronScope::CRON_LOGS->value)
        ]);
    Route::get('/cron/logs/{id}', [AdminLogsController::class, 'view'])
        ->middleware([
            AccessControlMiddleware::scopes(CronScope::CRON_LOGS_DETAILS->value)
        ]);

    Route::group(['prefix' => 'cron/commands'], function () {
        Route::get('/', [CommandsController::class, 'list'])
            ->middleware([
                AccessControlMiddleware::scopes(CronScope::COMMANDS->value)
            ]);
        Route::post('/execute', [CommandsController::class, 'execute'])
            ->middleware([
                AccessControlMiddleware::scopes(CronScope::COMMAND_EXEC->value)
            ]);
        Route::post('/common-data', [CommandsController::class, 'common'])
            ->middleware([
                AccessControlMiddleware::scopes(CronScope::COMMAND_EXEC->value)
            ]);
        Route::get('/logs', [CommandsLogsController::class, 'index'])
            ->middleware([
                AccessControlMiddleware::scopes(CronScope::COMMANDS_LOGS->value)
            ]);
        Route::get('/logs/{id}', [CommandsLogsController::class, 'view'])
            ->middleware([
                AccessControlMiddleware::scopes(CronScope::COMMANDS_LOGS_DETAILS->value)
            ]);
    });

});
