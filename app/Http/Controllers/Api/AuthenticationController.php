<?php

namespace App\Http\Controllers\Api;

use App\Facades\Auth;
use App\Facades\SafeVar;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function sendSmsCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric'
        ], [
            'phone.required' => 'Необходимо указать номер телефона!',
            'phone.numeric' => 'Номер телефона должен состоять только из цифр!'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $phone = $request->input('phone');
        $secureCode = '';

        if (strlen($phone) < 11 or strlen($phone) > 14) {
            throw new Exception('В номере телефона должно быть от 11 до 14 цифр!');
        }

        try {
            while (true) {
                $secureCode .= random_int(0, 9);

                if (strlen($secureCode) >= 6) {
                    break;
                }
            }
        } catch (Throwable $e) {
            throw new Exception('Не удалось сгенерировать SMS-код! Повторите попытку заново!');
        }

        try {
            $phoneUuid = SafeVar::add($phone);
            $secureCodeUuid = SafeVar::add($secureCode);
        } catch (Throwable $e) {
            throw new Exception('Не удалось сохранить номер телефона или SMS-код! Повторите попытку заново!');
        }

        return response()->json([
            'phone_uuid' => encrypt($phoneUuid, false),
            'code_uuid' => encrypt($secureCodeUuid, false)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'bail|required|email',
                'password' => 'bail|required|min:8'
            ],
            [
                'email.required' => __('messages.email-required'),
                'email.email' => __('messages.email-wrong-format'),
                'password.required' => __('messages.password-required'),
                'password.min' => __('messages.min-password-length')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $authStatus = Auth::login($request->input('email'), $request->input('password'));

        return response()->json($authStatus);
    }
}
