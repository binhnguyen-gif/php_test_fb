<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function response($code = 200, $msg = '', $items = []): \Illuminate\Http\JsonResponse
    {
        $json = [
            'code'  => $code,
            'msg'   => $msg,
            'data' => [],
        ];

        if ($items) {
            foreach ($items as $key => $item) {
                $json['data'][$key] = $item;
            }
        }
        return response()->json($json);
    }

}
