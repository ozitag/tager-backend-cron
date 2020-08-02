<?php

use Illuminate\Support\Facades\Route;
use OZiTAG\Tager\Backend\Cron\Controllers\AdminLogsController;

Route::group(['prefix' => 'admin', 'middleware' => ['provider:administrators', 'auth:api']], function () {
    Route::get('/cron/logs', [AdminLogsController::class, 'index']);
});
