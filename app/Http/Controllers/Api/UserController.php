<?php

namespace App\Http\Controllers\Api;

use App\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{

    /**
     * Update user
     *
     * @param Request $request
     * @return bool[]
     * @throws Exception
     */
    public function update(Request $request): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'bail|required|min:2|max:32',
                'last_name' => 'bail|min:2|max:32',
                'email' => 'bail|required|email|max:128',
                'phone' => ['bail', 'required', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/'],
                'new_password' => 'bail|nullable|string|min:8|confirmed',
                'new_password_confirmation' => 'bail|nullable'
            ],
            [
                'first_name.required' => __('messages.user-first-name-required'),
                'first_name.min' => __('messages.user-first-name-min'),
                'first_name.max' => __('messages.user-first-name-max'),
                'last_name.min' => __('messages.user-last-name-min'),
                'last_name.max' => __('messages.user-last-name-max'),
                'email.required' => __('messages.user-email-required'),
                'email.email' => __('messages.user-email-email'),
                'email.max' => __('messages.user-email-max'),
                'phone.required' => __('messages.user-phone-required'),
                'phone.regex' => __('messages.user-phone-regex'),
                'new_password.min' => __('messages.password-min'),
                'new_password.confirmed' => __('messages.password-confirmed')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $user = Auth::user();

        $emailUniqueCheck = User::where('email', $request->input('email'))
            ->where('id', '!=', $user->id)->get()->first();

        if ($emailUniqueCheck) {
            throw new Exception(__('messages.user-email-unique'));
        }

        if ($user->first_name !== $request->input('first_name')) {
            $user->first_name = $request->input('first_name');
        }

        if ($request->has('last_name')) {
            if ($user->last_name !== $request->input('last_name')) {
                $user->last_name = $request->input('last_name');
            }
        }

        if ($user->email !== $request->input('email')) {
            $user->email = $request->input('email');
        }

        $userPhone = $user->phone_code . $user->getOriginal('phone');

        if ($userPhone !== $request->input('phone')) {
            $phone = substr($request->input('phone'), -10);
            $phoneCode = Str::before($request->input('phone'), $phone);

            $user->phone_code = $phoneCode;
            $user->phone = $phone;
        }

        if ($request->has('new_password')) {
            $passwordWasUpdated = true;
            $user->password = Hash::make($request->input('new_password'));
        }

        $user->save();

        if (isset($passwordWasUpdated)) {
            $authCookies = Auth::login($user->email, $request->input('new_password_confirmation'));
        }

        return [
            'status' => true,
            'message' => __('messages.updating-success'),
            'cookies' => isset($passwordWasUpdated) ? $authCookies['cookies'] : []
        ];
    }

    /**
     * Update user's profile photo
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function uploadProfilePhoto(Request $request): array
    {
        $file = $request->file('profile_photo');

        if (!$file) {
            throw new Exception(__('messages.file-required'));
        }

        if ($file->getSize() > 500000) {
            throw new Exception(__('messages.profile-photo-size-max'));
        }

        if (!in_array($file->extension(), ['png', 'jpg', 'jpeg'])) {
            throw new Exception(__('messages.allowed-file-extensions'));
        }

        $file->storeAs('profile_pictures', Auth::user()->id . '.jpg');

        return [
            'status' => true,
            'message' => __('messages.file-uploading-success')
        ];
    }
}
