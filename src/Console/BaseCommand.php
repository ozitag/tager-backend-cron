<?php

namespace OZiTAG\Tager\Backend\Cron\Console;

use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    abstract function process();

    private function onStart()
    {

    }

    private function onEnd()
    {

    }

    public function handle()
    {
        $this->onStart();
        $this->process();
        $this->onEnd();
    }
}
