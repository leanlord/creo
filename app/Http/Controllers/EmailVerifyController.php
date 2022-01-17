<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Mailers\Mailer;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    protected Mailer $mailer;
    protected Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public static function send(Mailer $mailer, User $user) {
        $token = \Hash::make(\Str::random(10));
        \DB::table('verify_tokens')
            ->insert([
                'token' => $token,
                'user_id' => $user->getAuthIdentifier(),
            ]);

        $mailer->send($user, $token);

        // TODO сделать сообщение flash о том что на адрес электронной почты отправлено письмо с верифаем и вывести
        // его на странице аккаунта
        return 'На Ваш адресс электронной почты отправлено письмо.';
    }

    public function verify() {
        $user = auth()->user();
        if ($this->request->has('token')) {
            $userToken = \DB::table('verify_tokens')
                ->where('token', $this->request->get('token'))
                ->where('user_id', $user->id)
                ->first();

            if ($userToken) {
                $user->email_verified_at = time() + 3600 * 3;
                $user->save();

                return view('pages.account')
                    ->with([
                        'verify' => 'Почта успешно подтверждена.'
                    ]);
            }
        }

        return view('pages.account')
            ->withErrors([
               'verify' => 'Неверный токен!'
            ]);
    }
}
