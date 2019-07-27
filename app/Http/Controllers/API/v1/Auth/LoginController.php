<?php

namespace App\Http\Controllers\API\v1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        $auth = $request->except(['remember_me']);

        if (auth()->attempt($auth, $request->remember_me) && auth()->user()->hasRole(['admin', 'superadmin'])) {
            $user = auth()->user();
            $accessToken = $user->createToken('authToken')->accessToken;
            $data = [
                'name' => $user->name,
                'role' => $user->role()->name,
                'token' => $accessToken
            ];
            return response()->json(['status' => 'success', 'data' => $data], 200);
        }

        return response()->json(['status' => 'failed']);
    }
}
