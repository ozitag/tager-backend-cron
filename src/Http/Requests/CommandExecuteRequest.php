<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Requests;


use \OZiTAG\Tager\Backend\Core\Http\FormRequest;

/**
 * @property string $command
 * @property bool $async
 * @property array $arguments
 */
class CommandExecuteRequest extends FormRequest
{
    public function rules() {
        return [
            'command' => ['string', 'required'],
            'async' => ['boolean', 'required'],
            'arguments' => ['array', 'nullable'],
            'arguments.*.name' => ['string', 'required'],
            'arguments.*.value' => ['string', 'nullable'],
        ];
    }
}
