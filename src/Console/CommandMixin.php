<?php

namespace OZiTAG\Tager\Backend\Cron\Console;

use OZiTAG\Tager\Backend\Cron\Dto\CommandParamDto;
use \RuntimeException;

class CommandMixin
{
    public function getSignature()
    {
        return fn () => explode(' ', $this->signature)[0];
    }

    public function getRawSignature()
    {
        return fn () => $this->signature;
    }

    public function getParams()
    {
        return function () {
            preg_match_all('/\{(.*?)\}/', $this->getRawSignature(), $params);
            $params = $params[1] ?? [];

            return array_map(function ($param) {
                $param = explode('=', $param);
                return new CommandParamDto(
                    array_shift($param), array_shift($param)
                );
            }, $params);
        };
    }

    public function executeHelpMethod() {
        return function (string $method_name, array $arguments = []) {
            if (!method_exists($this, $method_name)) {
                throw new RuntimeException('Helper method does\'t exists');
            }
            return $this::$method_name($arguments);
        };
    }
}
