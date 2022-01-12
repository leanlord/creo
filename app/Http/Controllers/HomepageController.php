<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Settings\UsersSettings;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    protected UsersSettings $settings;

    public function __construct() {
        $this->settings = new UsersSettings();
    }

    public function index()
    {
        return view('pages.account');
    }

    /*
     * Обновление личных данных пользователя
     */
    public function update(Request $request)
    {
        $validateFields = $request->validate([
            'email' => 'email',
            'password' => 'nullable|min:7',
            'first_name' => '',
            'last_name' => '',
            'number' => ''
        ]);

        $user = new User;
        // Заполнение каждого аттрибута пользователя для сохранения
        foreach ($this->settings->getAttributes() as $attribute) {
            if (isset($validateFields[$attribute])) {
                $user->$attribute = $validateFields[$attribute];
            }
        }

        // Если такой емейл уже существует
        $email = User::select('email')->where('email', $request->input('email'))->first();
        if ($email !== null) {
            return view('pages.account',
                ['thisUserAlreadyExists' => 'Этот адресс электронной почты уже занят другим пользователем!']);
        }

        $user->save();
        auth()->login($user, true);

        return view('pages.account', ['success' => true]);
    }
}
