<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Abstract\UserController;
use Illuminate\Http\Request;

class CustomerUserController extends UserController
{
    public function showUserByCardNumber(Request $request) {
        $cardNumber = $request->card_number;
        return $this->_showUserByCardNumber($cardNumber);
    }
}
