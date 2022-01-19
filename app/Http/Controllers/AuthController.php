<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('pages.login');
    }

    public function login(AuthRequest $request) {
//        dd($request->validated());
        if (Auth::attempt($request->validated(), true)) {
            return redirect('/account');
        }

        return view('pages.login')->withErrors([
            'auth' => 'Введен неверный логин или пароль.',
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect('/account');
    }
}
