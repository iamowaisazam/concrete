<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct($user)
    {
        $this->user = $user;
        $this->token = $user->email_verification_token; // 6-digit OTP
    }

    public function build()
    {
        $verifyUrl = url('/verify-email/' . $this->user->email); // optional URL
        return $this->subject('Verify Your Email Address')
                    ->markdown('emails.verify')
                    ->with([
                        'name' => $this->user->firstName,
                        'verifyUrl' => $verifyUrl,
                        'token' => $this->token, // pass token to email
                    ]);
    }
}
