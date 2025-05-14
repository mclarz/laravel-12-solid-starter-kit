<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    use ResponseTrait;

    /**
     * Handle login both for admin and user
     */
    public function __invoke(LoginRequest $request)
    {

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {

            $this->unauthorized();
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return $this->success("Success", [
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
