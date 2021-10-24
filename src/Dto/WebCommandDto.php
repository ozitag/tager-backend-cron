<?php
namespace OZiTAG\Tager\Backend\Cron\Dto;

use \OZiTAG\Tager\Backend\Backup\Dto\Dto;

class WebCommandDto extends Dto
{
    public function __construct(
       protected string $signature, 
       protected ?array $params, 
    ) {}

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }
}
