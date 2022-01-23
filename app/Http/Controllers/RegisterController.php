<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function index() {
        return view('pages.register');
    }

    public function register(UpdateAccountRequest $request) {
        $validated = $request->validated();

        if (User::where('email', $validated['email'])->exists()) {
            return view('pages.register')->withErrors([
                'email' => 'Данный адрес электронной почты занят.',
            ]);
        }

        $user = User::create($validated);
        if ($user) {
            auth()->login($user, true);
            return redirect(route('account'));
        }

        return view('pages.register')->withErrors([
            'register' => 'Не удалось зарегистрироваться. Пожалуйста, повторите попытку позже.',
        ]);
    }
}
