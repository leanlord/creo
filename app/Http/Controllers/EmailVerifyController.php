<?php

namespace App\Http\Controllers;

use App\Services\Mailers\Mailer;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    protected Mailer $mailer;
    protected Request $request;

    public function __construct(Mailer $mailer, Request $request) {
        $this->mailer = $mailer;
        $this->request = $request;
    }

    public function send() {
        $token = \Hash::make(\Str::random(10));
        \DB::table('verify_tokens')
            ->insert([
                'token' => $token,
                'user_id' => auth()->user()->getAuthIdentifier(),
            ]);

        $this->mailer->send(auth()->user(), $token);

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
                $user->email_verified_at = time();
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
