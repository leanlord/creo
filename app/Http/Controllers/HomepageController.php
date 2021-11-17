<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Plugins\Settings\UsersSettings;
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

        $passwordParams = '';
        if ($request->getPassword() !== null) {
            $passwordParams = 'min:7';
        }

        $validateFields = $request->validate([
            'email' => 'email',
            'password' => $passwordParams,
            'first_name' => '',
            'last_name' => '',
            'number' => ''
        ]);

        // Заполнение каждого аттрибута пользователя для сохранения
        foreach (UsersSettings::getAttributes() as $attribute) {
            if (isset($validateFields[$attribute])) {
                $user->$attribute = $validateFields[$attribute];
            }
        }

        // Если такой емейл уже существует
        $email = User::select('email')->where('email', '=', $request->input('email'))->first();
        if ($email !== null) {
            return view('pages.account',
                ['thisUserAlreadyExists' => 'Этот адресс электронной почты уже занят другим пользователем!']);
        }

        $user->save();

        auth()->login($user);

        return view('pages.account', ['success' => true]);
    }
}
