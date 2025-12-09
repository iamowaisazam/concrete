<?php
namespace App\Mail;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlanUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;
    public $user;

    public function __construct(Plan $plan, User $user)
    {
        $this->plan = $plan;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('New Special Plan Available')
                    ->markdown('emails.planupdated');
    }
}

