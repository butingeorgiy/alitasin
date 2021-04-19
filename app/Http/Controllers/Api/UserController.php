<?php

namespace App\Http\Controllers\Api;

use App\Facades\Auth;
use App\Facades\Hash;
use App\Facades\SafeVar;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class UserController extends Controller
{
    /**
     * Create a new user
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'bail|required|min:5|max:128|string',
            'email' => 'bail|required|email|max:128|unique:users',
            'code' => 'bail|required|numeric',
            'account_type_id' => 'bail|in:1,2,3,4'
        ], [
            'full_name.required' => 'Необходимо указать ФИО!',
            'full_name.min' => 'Минимальная длина ФИО 5 букв!',
            'full_name.max' => 'Максимальная длина ФИО 128 букв!',
            'full_name.string' => 'ФИО может состоять только из букв!',
            'email.required' => 'Необходимо указать e-mail!',
            'email.email' => 'Некорректный e-mail!',
            'email.max' => 'Максимальная длина e-mail 128 символов!',
            'email.unique' => 'Указанный e-mail уже зарегестрирован!',
            'code.required' => 'Необходимо указать код!',
            'code.numeric' => 'Код может состоять только из цифр!',
            'account_type_id.in' => 'Неизвестный тип аккаунта!'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $phoneUuid = $request->cookie('phone_uuid');
        $codeUuid = $request->cookie('code_uuid');

        if (!$phoneUuid) {
            throw new Exception('Не удалось расшифровать номер телефона! Скорее всего он не был отправлен на сервер или был искажён!');
        }

        if (!$codeUuid) {
            throw new Exception('Не удалось расшифровать код! Скорее всего он не был отправлен на сервер или был искажён!');
        }

        $phone = SafeVar::get($phoneUuid);
        $code = SafeVar::get($codeUuid);

        if (!$phone) {
            throw new Exception('Не удалось получить номер телефона!');
        }

        if (!$code) {
            throw new Exception('Не удалось получить код!');
        }

        if ($code !== $request->input('code')) {
            throw new Exception('Неверный код!');
        }

        if (User::byPhone($phone)->get()->first()) {
            throw new Exception('Указанный номер уже зарегистрирован!');
        }

        try {
            $user = new User();

            $user->full_name = $request->input('full_name');
            $user->phone = substr($phone, -10);
            $user->phone_code = Str::before($phone, $user->phone);
            $user->email = $request->input('email');

            if ($request->has('account_type_id')) {
                $accountType = strval($request->input('account_type_id'));

                if ($accountType !== '1') {
                    if (Auth::check(['5'])) {
                        $user->account_type_id = $accountType;
                    } else {
                        throw new Exception('У вас недостаточно прав, чтобы создавать новых пользователей!');
                    }
                }
            }

            $password = Str::random(12);
            $user->password =  Hash::make($password, $user);

            $user->save();
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }

        SafeVar::destroy($phoneUuid);
        SafeVar::destroy($codeUuid);

        $authStatus = Auth::login($phone, collect(['password' => $password]));

        if ($authStatus['status'] === true) {
            return [
                'status' => true,
                'cookies' => $authStatus['cookies']
            ];
        } else {
            throw new Exception('Новый пользователь успешно создан, но его не удалось авторизовать! Попробуйте авторизоваться вручную!');
        }
    }

    /**
     * Update user
     *
     * @param Request $request
     * @param null $id
     * @return bool[]
     * @throws Exception
     */
    public function update(Request $request, $id = null)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'bail|required|min:2|max:32',
                'last_name' => 'bail|min:2|max:32',
                'email' => 'bail|required|email|max:128',
                'phone' => ['bail', 'required', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/']
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
                'phone.regex' => __('messages.user-phone-regex')
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

        $user->save();

        return [
            'status' => true,
            'message' => __('messages.updating-success')
        ];
    }

    /**
     * Update user's profile photo
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function uploadProfilePhoto(Request $request)
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
