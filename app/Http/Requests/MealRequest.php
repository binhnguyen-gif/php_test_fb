<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class MealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'meal' => 'required|string',
            'number' => [
                'required',
                'integer',
                 Rule::in(1,2,3,4,5,6,7,8,9,10)
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống.',
            'number.in' => ':attribute lớn hơn 0 và nhỏ hơn 10.',
            'integer' => ':attribute phải là số.',
        ];
    }

    public function attributes()
    {
        return [
          'meal' => 'Bữa ăn',
          'number' => 'Số người',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            Controller::response(422, [
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()->toArray()
                ]
            )
        );
    }
}
