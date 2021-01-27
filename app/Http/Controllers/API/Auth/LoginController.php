<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request){

    	$credentials = $request->only(['email','password']);
    	$token = auth()->attempt($credentials);
    	return $token;

    }
}
