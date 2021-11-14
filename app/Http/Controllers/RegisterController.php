<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request) {
        // если пользователь авторизован вернуть в профиль
        if (Auth::check()) {
            return redirect('/profile');
        }

        if ($request->method() == 'POST') {
            $validateFields = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:7',
                'first_name' => '',
                'last_name' => '',
                'number' => ''
            ]);

            if (User::where('email', $validateFields['email'])->exists()) {
                return view('pages.register',
                    // и выводить ссылку на /login
                    ['thisUserAlreadyExists' => 'Такой пользователь уже зарегистрирован! Не желаете войти?']);
            }

            $user = User::create($validateFields);
            /**
             * если все прошло успешно
             * аутентифицируем пользователя
             * и редиректим на профиль
             */
            if ($user) {
                auth()->login($user);
                return redirect(route('account'));
            }
            // иначе произошла ошибка
            return view('pages.register', ['registerError' => 'Не удалось зарегистрироваться']);
        } else { // если пользователь только зашел на страницу
            return view('pages.register');
        }
    }
}
