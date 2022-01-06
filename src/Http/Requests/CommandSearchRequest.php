<?php

namespace OZiTAG\Tager\Backend\Cron\Http\Requests;


use \OZiTAG\Tager\Backend\Core\Http\FormRequest;

class CommandSearchRequest extends FormRequest
{
    public function rules() {
        return [
            'query' => ['string', 'nullable', 'max:250'],
        ];
    }
}
