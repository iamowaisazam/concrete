<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Interest;

class InterestCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $interest;

    public function __construct(Interest $interest)
    {
        $this->interest = $interest;
    }

    public function build()
    {
        return $this->subject('Your Created New Interest')
                    ->markdown('emails.create_interest');
    }
}
