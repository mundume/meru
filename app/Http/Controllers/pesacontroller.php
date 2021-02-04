<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pesacontroller extends Controller
{
    public function stk_push($identifier, $amount, $contact,$callback,$remarks) {
        $response = [
            'ResponseCode' => 1
        ];
        return $response;
    }
    public function stk_callback() {
        
    }
}
