<?php

namespace App\Services;

use App\Facades\Hash;
use App\Facades\SafeVar;
use App\Facades\Token;
use App\Models\User;
use Illuminate\Support\Collection;
use Exception;
use Throwable;

class AuthenticationService
{
    /**
     * @param string $email
     * @param string $password
     * @return array
     * @throws Exception
     */
    public function login(string $email, string $password): array
    {
        $user = User::where('email', $email)->select(['id', 'email', 'password', 'account_type_id'])->get()->first();

        if (!$user) {
            throw new Exception(__('messages.user-not-found'));
        }

        $userHasAccess = self::byPassword($user, $password);

        if (!$userHasAccess) {
            throw new Exception(__('messages.wrong-password'));
        }

        $token = Token::create($user);

        if(in_array($user->account_type_id, ['3', '4', '5'])) {
            $redirectTo = route('admin-index');
        } else if (in_array($user->account_type_id, ['1', '2'])) {
            $redirectTo = route('profile-index');
        } else {
            $redirectTo = route('index');
        }

        return [
            'status' => true,
            'redirect_to' => $redirectTo,
            'cookies' => [
                'id' => encrypt($user->id),
                'token' => $token
            ]
        ];
    }

    /**
     * @param null $accountType
     * @return bool
     */
    public function check($accountType = null): bool
    {
        try {
            return Token::check($accountType);
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * @return null|User
     */
    public function user()
    {
        $isAuth = self::check();

        if ($isAuth !== true) {
            return null;
        } else {
            return User::find(decrypt(request()->cookie('id')));
        }
    }

    /**
     * @param $user
     * @param $password
     * @return bool
     */
    private function byPassword($user, $password): bool
    {
        return Hash::check($password, $user);
    }
}
