<?php


namespace App\Services;


use App\Facades\Token;
use App\Models\User;
use Exception;

class RegistrationService
{
    /**
     * Register a new user
     *
     * @param string $phone
     * @param string $phoneCode
     * @param string $email
     * @param string $firstName
     * @param mixed $lastName
     * @param string $accountTypeId
     * @param bool $tokenGenerate
     * @return array
     * @throws Exception
     */
    public function reg(string $phone, string $phoneCode, string $email, string $firstName,
                        $lastName = null, string $accountTypeId = '1', bool $tokenGenerate = true): array
    {
        if (!User::isEmailUnique($email)) {
            throw new Exception(__('messages.user-email-unique'));
        }

        $user = new User(compact('phone', 'email'));

        $user->phone_code = $phoneCode;
        $user->first_name = $firstName;
        $user->account_type_id = $accountTypeId;

        if ($lastName) {
            $user->last_name = $lastName;
        }

        $password = $user->generatePassword();

        if (!$user->save()) {
            throw new Exception(__('messages.user-creating-failed'));
        }

        $this->notify($email, $password);

        $response = [
            'status' => true,
            'user' => $user
        ];

        if ($tokenGenerate === true) {
            $token = Token::create($user);
            $response['cookies'] = [
                'id' => encrypt($user->id, false),
                'token' => $token
            ];
        }

        return $response;
    }


    public function notify(string $email, string $password): void
    {
        //
    }
}
