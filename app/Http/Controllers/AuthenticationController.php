<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Facades\Token;
use App\Models\AuthToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;

class AuthenticationController extends Controller
{
    /**
     * Logout user
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
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
