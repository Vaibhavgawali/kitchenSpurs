<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class LoginController extends Controller
{

    /**
     * Login user.
     */
    public function login(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            return Response(['success' => false, 'message' => $validator->errors()], 401);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            $success =  $user->createToken('MyApp')->plainTextToken;

            return Response(['success' => true, 'token' => $success], 200);
        }

        return Response(['success' => false, 'message' => 'email or password wrong'], 401);
    }
}
