<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(UserRequest $request) {
        $validated = $request->validated();
        if (Auth::check()) {
            return redirect('/account');
        }

        if ($request->method() == 'POST') {
            $formFields['email'] = $validated['email'];
            $formFields['password'] = $validated['password'];
            if (Auth::attempt($formFields, true)) {
                return redirect('/account');
            }
        } else {
            return view('pages.login');
        }

        return view('pages.login')->withErrors([
            'auth' => 'Введен неверный логин или пароль.'
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect('/account');
    }
}
