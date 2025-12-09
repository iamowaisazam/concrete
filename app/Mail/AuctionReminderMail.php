<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Auctions;

class AuctionReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $auction;

    /**
     * Create a new message instance.
     */
    public function __construct(Auctions $auction)
    {
        $this->auction = $auction;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Auction Reminder')
                    ->view('emails.auction_reminder'); // Blade view banani hai
    }
}
