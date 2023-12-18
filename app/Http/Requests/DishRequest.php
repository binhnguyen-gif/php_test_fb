<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Rules\DishRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DishRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'meal' => 'required|string',
            'restaurant' => 'required|string',
            'dish.*' => 'required|string',
            'dish' => new DishRule($request),
            'number' => [
                'required',
                'integer',
                Rule::in(1,2,3,4,5,6,7,8,9,10)
            ],
            'number_serving.*' => [
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
            'number_serving.*.in' => ':attribute không được vượt quá 10.',
            'number.in' => ':attribute không được vượt quá 10.',
            'integer' => ':attribute phải là số.',
            'number_serving.*.required' => 'Trường :attribute là bắt buộc',
            'dish.*.required' => 'Trường :attribute là bắt buộc',
            'dish.*.string' => 'Trường :attribute phải thuộc kiểu chuỗi',
            'number_serving.*.integer' => 'Trường :attribute phải là số nguyên',
        ];
    }

    public function attributes()
    {
        return [
            'meal' => 'Bữa ăn',
            'restaurant' => 'Nhà hàng',
            'dish.*' => 'Món ăn',
            'number' => 'Số người',
            'number_serving.*' => 'Khẩu phần',
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
