<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Requests;


use \OZiTAG\Tager\Backend\Core\Http\FormRequest;

class CommandCommandDataRequest extends FormRequest
{
    public function rules() {
        return [
            'command' => ['string', 'required'],
            'method' => ['string', 'required'],
            'arguments' => ['array', 'nullable'],
            'arguments.*.name' => ['string', 'required'],
            'arguments.*.value' => ['string', 'nullable'],
        ];
    }
}
