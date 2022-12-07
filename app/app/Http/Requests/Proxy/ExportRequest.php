<?php

namespace App\Http\Requests\Proxy;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExportRequest extends FormRequest
{
    public const IP_PORT_LOGIN_PASS_FORMAT = 'ip:port@login:password';
    public const IP_PORT_FORMAT = 'ip:port';
    public const IP_FORMAT = 'ip';
    public const IP_LOGIN_PASS_FORMAT = 'ip@login:password';

    //format (возможные варианты: ip:port@login:password; ip:port; ip; ip@login:password).
    public const FORMATS = [
        self::IP_PORT_LOGIN_PASS_FORMAT,
        self::IP_PORT_FORMAT,
        self::IP_FORMAT,
        self::IP_LOGIN_PASS_FORMAT,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'format' => [
                'required',
                Rule::in(self::FORMATS),
            ]
        ];
    }
}
