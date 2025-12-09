<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyVehicleSummary extends Mailable
{
    use Queueable, SerializesModels;

    public $summary;

    public function __construct($summary)
    {
        $this->summary = $summary;
    }

    public function build()
    {
        return $this->subject("Daily Vehicle Summary - {$this->summary['date']}")
                    ->markdown('emails.daily_summary');
    }
}
