<?php

namespace App\Services\Mailers;

interface Mailer
{
    public function send($user, $data = []);
}
