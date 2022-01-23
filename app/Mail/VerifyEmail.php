<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $verifyToken = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $verifyToken) {
        $this->user = $user;
        $this->verifyToken = $verifyToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from('www.creo.com@gmail.com')
            ->view('mail.verify');
    }
}
