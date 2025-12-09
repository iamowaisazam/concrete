<?php

namespace App\Jobs;

use App\Mail\InterestCreatedMail;
use App\Models\Interest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class SendInterestCreatedMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $interest;
    public $email;

    /**
     * Create a new job instance.
     */
    public function __construct(Interest $interest, $email)
    {
        $this->interest = $interest;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->email)
            ->send(new InterestCreatedMail($this->interest));
    }
}
