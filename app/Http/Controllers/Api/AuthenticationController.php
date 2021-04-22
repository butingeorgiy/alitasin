<?php

namespace App\Http\Controllers\Api;

use App\Facades\Auth;
use App\Facades\Reg;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(Request $request): JsonResponse
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

    /**
     * Register a new user
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function reg(Request $request): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'bail|required|min:2|max:32',
                'email' => 'bail|required|max:128|unique:users',
                'phone' => ['bail', 'required', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/']
            ],
            [
                'first_name.required' => __('messages.user-first-name-required'),
                'first_name.min' => __('messages.user-first-name-min'),
                'first_name.max' => __('messages.user-first-name-max'),
                'email.required' => __('messages.user-email-required'),
                'email.max' => __('messages.user-email-max'),
                'email.unique' => __('messages.user-email-unique'),
                'phone.required' => __('messages.user-phone-required'),
                'phone.regex' => __('messages.user-phone-regex')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $firstName = $request->input('first_name');
        $email = $request->input('email');
        $phone = substr($request->input('phone'), -10);
        $phoneCode = Str::before($request->input('phone'), $phone);

        $registrationResponse = Reg::reg($phone, $phoneCode, $email, $firstName);

        return [
            'status' => true,
            'cookies' => $registrationResponse['cookies']
        ];
    }
}
