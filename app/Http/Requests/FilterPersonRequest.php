<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterPersonRequest extends FormRequest
{
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
    public function rules()
    {
        return [
            'order' => 'sometimes|string|in:asc,desc',
            'sort' => 'sometimes|string|in:name,age,city',
            'minAge' => 'sometimes|integer|between:1,200',
            'maxAge' => 'sometimes|integer|between:1,200',
        ];
    }
}
