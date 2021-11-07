<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect('/account');
        }

        if ($request->method() == 'POST') {
            $formFields = $request->only(['email', 'password']);
            if (Auth::attempt($formFields)) {
                return redirect('/account');
            }
        } else {
            return view('/login');
        }

        // Если произошла какая то ошибка
        return view('/login', ['loginError' => 'Введен неверный логин или пароль.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/account');
    }
}
