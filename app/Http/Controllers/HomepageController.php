<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        return view('pages.account');
    }

    /*
     * Обновление личных данных пользователя
     */
    public function update(Request $request)
    {
        $id = auth()->user()->getAuthIdentifier();
        $user = User::find($id);

        $validateFields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:7',
            'first_name' => '',
            'last_name' => '',
            'number' => ''
        ]);

        if (
            User::where('email', $validateFields['email'])
            ->where('id', '<>', $id)
            ->exists()
        ) {
            return view('pages.account',
                // и выводить ссылку на /login
                ['thisUserAlreadyExists' => 'Этот адресс электронной почты уже занят другим пользователем!']);
        }

        if (isset($validateFields['first_name'])) {
            $user->first_name = $validateFields['first_name'];
        }

        if (isset($validateFields['last_name'])) {
            $user->last_name = $validateFields['last_name'];
        }

        if (isset($validateFields['email'])) {
            $user->email = $validateFields['email'];
        }

        if (isset($validateFields['password'])) {
            $user->password = $validateFields['password'];
        }

        if (isset($validateFields['number'])) {
            $user->number = $validateFields['number'];
        }

        $user->save();

        auth()->login($user);

        return view('pages.account', ['success' => true]);
    }
}
