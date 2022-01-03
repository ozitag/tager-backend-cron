<?php

namespace OZiTAG\Tager\Backend\Cron\Events;

class TagerCommandFinished
{
    public function __construct(
      private int $command_id,
      private ?string $output,
      private ?float $microtime,
    ) {}

    public function getCommandId(): int
    {
        return $this->command_id;
    }

    public function getOutput(): ?string
    {
        return $this->output;
    }

    public function getMicrotime(): ?float
    {
        return $this->microtime;
    }
}
