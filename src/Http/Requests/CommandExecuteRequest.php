<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Requests;


use \OZiTAG\Tager\Backend\Core\Http\FormRequest;

class CommandExecuteRequest extends FormRequest
{
    public function rules() {
        return [
            'command' => ['string', 'required'],
            'arguments' => ['array', 'nullable'],
            'arguments.*.name' => ['string', 'required'],
            'arguments.*.value' => ['string', 'nullable'],
        ];
    }
}
