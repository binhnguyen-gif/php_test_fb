<?php

namespace App\Rules;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class DishRule implements ValidationRule
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $number_serving = $this->request->number_serving;
        $number = $this->request->number;
        $totalServing = array_sum($number_serving);

        if ($this->hasDuplicates($value)) {
//            $fail(':attribute không thể chọn cùng một món ăn nhiều lần.');
            throw new HttpResponseException(
                Controller::response(422, [
                        'message' => 'Không thể chọn cùng một món ăn nhiều lần.',
                    ]
                )
            );
        }

        if ($totalServing < $number) {
//            $fail('Tổng số món ăn phải lớn hơn hoặc bằng số người chọn.');
            throw new HttpResponseException(
                Controller::response(422, [
                        'message' => 'Tổng số món ăn phải lớn hơn hoặc bằng số người chọn.',
                    ]
                )
            );
        }

        if (is_array($value) && $value < 10) {
//            $fail(':attribute không được vượt quá 10 món.');
            throw new HttpResponseException(
                Controller::response(422, [
                        'message' => 'Tổng số món ăn không được vượt quá 10 món',
                    ]
                )
            );
        }
    }

    protected function hasDuplicates($arr)
    {
        $uniqueValues = array_unique($arr);
        return count($arr) != count($uniqueValues);
    }
}
