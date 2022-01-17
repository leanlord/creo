<?php

namespace App\Services\Mailers;

use App\Mail\VerifyEmail;

class VerifyMailer implements Mailer
{
    public function send($user, $data = []) {
        \Mail::to($user->email)
        ->send(new VerifyEmail($user, $data));
    }
}
