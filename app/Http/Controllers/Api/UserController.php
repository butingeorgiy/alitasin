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
        if ($id !== null) {
            if (Auth::check(['5'])) {
                $user = User::find($id);
            } else {
                throw new Exception('У вас недостаточно прав, чтобы редактировать пользователей!');
            }
        } else {
            $user = Auth::user();
        }

        if (!$user) {
            throw new Exception('Пользователь не найден!');
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'bail|string|min:5|max:128',
            'email' => 'bail|email|max:128|unique:users'
        ], [
            'full_name.string' => 'ФИО может состоять только из букв!',
            'full_name.min' => 'Минимальная длина ФИО 5 букв!',
            'full_name.max' => 'Максимальная длина ФИО 128 букв!',
            'email.email' => 'Некорректный e-mail!',
            'email.max' => 'Максимальная длина e-mail 128 символов!',
            'email.unique' => 'Указанный e-mail уже зарегестрирован!'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $needToUpdate = false;

        if ($request->has('full_name')) {
            if ($request->input('full_name') !== $user->full_name) {
                $user->full_name = $request->input('full_name');
                $needToUpdate = true;
            }
        }

        if ($request->has('email')) {
            if ($request->input('email') !== $user->email) {
                $user->email = $request->input('email');
                $needToUpdate = true;
            }
        }

        if ($needToUpdate === false) {
            throw new Exception('Данные не были изменены!');
        }

        $user->save();

        return [
            'status' => true
        ];
    }
}
