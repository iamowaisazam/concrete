<?php


namespace App\Mail;

use App\Models\Auctions;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $auction;

    public $newStatus;

    public function __construct(Auctions $auction, $newStatus)
    {
        $this->auction = $auction;
        $this->newStatus = $newStatus;
    }

    public function build()
    {
        return $this->subject('Auction Delays / Status Update Notification')
                    ->view('emails.auction_status_update');
    }
}

