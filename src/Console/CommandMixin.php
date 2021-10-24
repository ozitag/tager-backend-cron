<?php

namespace OZiTAG\Tager\Backend\Cron\Console;

use OZiTAG\Tager\Backend\Cron\Dto\CommandParamDto;

class CommandMixin
{
    public function getSignature()
    {
        return fn () => $this->signature;
    }

    public function getParams()
    {
        return function () {
            preg_match_all('/\{(.*?)\}/', $this->getSignature(), $params);
            $params = $params[1] ?? [];

            return array_map(function ($param) {
                $param = explode('=', $param);
                return new CommandParamDto(
                    array_shift($param), array_shift($param)
                );
            }, $params);
        };
    }

}
