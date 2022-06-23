<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function jsonAbort($message = '', $code = 404) {
        $errors = ['errors' => $message];
        abort(response()->json($errors, $code));
    }

    protected function jsonSuccess() {
        return response()->json([
            'success' => true,
        ]);
    }

    protected function generateCode($n) {
        $chars = '01234567890';
        $code = '';
        for ($x = 0; $x < $n; $x++) {
            $code .= $chars[ rand(0, strlen($chars)-1) ];
        }
        return $code;
    }
}
