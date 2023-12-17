<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RestaurantRequest extends FormRequest
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
            'restaurant' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống.',
        ];
    }

    public function attributes()
    {
        return [
            'meal' => 'Bữa ăn',
            'restaurant' => 'Cửa hàng',
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
