<?php

namespace OZiTAG\Tager\Backend\Cron\Dto;

class WebCommandDto
{
    public function __construct(
        protected string  $signature,
        protected ?string $description,
        protected ?array  $params,
    )
    {
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function getParams(): ?array
    {
        return $this->params;
    }
}
