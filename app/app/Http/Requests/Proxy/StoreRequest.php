<?php

namespace App\Http\Requests\Proxy;

use App\Models\Provider;
use App\Models\Proxy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreRequest
 */
class StoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ip' => [
                'required',
                'ipv4',
            ],
            'port' => [
                'required',
                'integer',
                'between:10,65000',
            ],
            'login' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'string',
            ],
            'status' => [
                'integer',
                Rule::in(array_keys(Proxy::STATUSES))
            ],
            'provider_id' => [
                'sometimes',
                'integer',
                Rule::exists(Provider::class, 'id')
            ],
        ];
    }

}
