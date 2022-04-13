<?php

namespace App\Services;

use App\Facades\Token;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;

class AuthenticationService
{
    /**
     * Login attempt.
     *
     * @param string $email
     * @param string $password
     *
     * @return array
     * @throws Exception
     */
    #[ArrayShape([
        'status' => "bool",
        'redirect_to' => "string",
        'cookies' => "array"
    ])]
    public function login(string $email, string $password): array
    {
        $user = User::where('email', $email)->select(['id', 'email', 'password', 'account_type_id'])->get()->first();

        if (!$user) {
            throw new Exception(__('messages.user-not-found'));
        }

        if (!Hash::check($password, $user->password)) {
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
     * Check authenticated status.
     *
     * @param array|null $accountType
     *
     * @return bool
     */
    public function check(?array $accountType = null): bool
    {
        try {
            return Token::check($accountType);
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * Get authenticated user instance.
     *
     * @return User|null
     */
    public function user(): ?User
    {
        $isAuth = self::check();

        if ($isAuth !== true) {
            return null;
        } else {
            return User::find(decrypt(request()->cookie('id')));
        }
    }
}
