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
            'success' => true
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

    protected function generateCardNumber() {
        do {
            $code = $this->generateCode(16);
        } while (false);
        return $code;
    }

    protected function tryAddPaginationAndLimit($collection, $request) {
        if ($request->limit) {
            return $collection->limit($request->limit)->get();
        }
        if ($request->paginate) {
            return $collection->paginate($request->paginate);
        }
        return $collection->get();
    }

    protected function storeImage($requestFile, $directory) {
        $file = $requestFile;
        $filename = date('YmdHi').$file->getClientOriginalName();
        $file->move(public_path($directory), $filename);
        $result = '/' . $directory . '/' . $filename;
        return str_replace('//', '/', $result);
    }
}
