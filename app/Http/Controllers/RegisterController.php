<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(UserRequest $request) {
        // если пользователь авторизован, вернуть в профиль
        if (Auth::check()) {
            return redirect('/profile');
        }

        if ($request->method() == 'POST') {
            $validated = $request->validated();

            if (User::where('email', $validated['email'])->exists()) {
                return view('pages.register',
                    // и выводить ссылку на /login
                    ['error' => 'Такой пользователь уже зарегистрирован! Не желаете войти?']);
            }

            $user = User::create($validated);
            if ($user) {
                auth()->login($user, true);
                return redirect(route('account'));
            }

            return view('pages.register', ['registerError' => 'Не удалось зарегистрироваться']);
        } elseif ($request->method() == 'GET') {
            return view('pages.register');
        }
    }
}
