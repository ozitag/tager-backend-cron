<?php

namespace OZiTAG\Tager\Backend\Cron\Dto;

class CommandParamDto
{
    public function __construct(
        protected string  $name,
        protected ?string $default_value,
    )
    {
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        $parts = explode(':', $this->name);
        return trim(array_shift($parts));
    }

    /**
     * @return string|null
     */
    public function getDefaultValue(): ?string
    {
        return $this->default_value;
    }

}
