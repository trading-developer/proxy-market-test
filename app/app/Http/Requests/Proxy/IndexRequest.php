<?php

namespace App\Http\Requests\Proxy;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class IndexRequest
 * @package App\Http\Requests\Proxy
 */
class IndexRequest extends FormRequest
{
    public const PER_PAGES = [10, 20, 50];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'per_page' => [
                'sometimes',
                Rule::in(self::PER_PAGES)
            ],
        ];
    }
}
