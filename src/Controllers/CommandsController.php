<?php

namespace OZiTAG\Tager\Backend\Cron\Controllers;

use OZiTAG\Tager\Backend\Core\Controllers\Controller;
use OZiTAG\Tager\Backend\Cron\Http\Features\CommandsListFeature;
use OZiTAG\Tager\Backend\Cron\Http\Features\CommandsViewFeature;
use OZiTAG\Tager\Backend\Cron\Http\Features\ExecuteCommandFeature;
use OZiTAG\Tager\Backend\Cron\Http\Features\GetCommandCommonDataFeature;
use OZiTAG\Tager\Backend\Cron\Repositories\TagerCronJobRepository;
use OZiTAG\Tager\Backend\Crud\Controllers\CrudController;

class CommandsController extends Controller
{
    public function list() {
        return $this->serve(CommandsListFeature::class);
    }
    
    public function view(string $signature) {
        return $this->serve(CommandsViewFeature::class, [
            'signature' => $signature,
        ]);
    }

    public function execute() {
        return $this->serve(ExecuteCommandFeature::class);
    }

    public function common() {
        return $this->serve(GetCommandCommonDataFeature::class);
    }
}
