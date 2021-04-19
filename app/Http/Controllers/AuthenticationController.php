<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Facades\Token;
use App\Models\AuthToken;
use Illuminate\Support\Facades\Cookie;

class AuthenticationController extends Controller
{
    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            $tokenId = Token::getId($user);

            AuthToken::destroy($tokenId);
        }

        return redirect()->route('index')
            ->cookie(Cookie::forget('id'))
            ->cookie(Cookie::forget('token'));
    }
}
