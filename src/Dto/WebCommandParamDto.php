<?php
namespace OZiTAG\Tager\Backend\Cron\Dto;

use \OZiTAG\Tager\Backend\Backup\Dto\Dto;

class WebCommandParamDto extends Dto
{
    public function __construct(
       protected string $name,
       protected ?array $values = null,
       protected ?string $default = null,
       protected ?string $method = null,
       protected ?string $description = null,
    ) {}

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values ?? [];
    }

    /**
     * @return string|null
     */
    public function getDefault(): ?string
    {
        return !$this->method ? $this->default : null;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
