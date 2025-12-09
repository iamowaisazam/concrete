<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auctions;
use App\Models\PlatefromAlert;
use App\Models\UserNotificationSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuctionReminderMail;
use App\Events\NotificationEvent;

class RemindersAuctions extends Command
{
    protected $signature = 'reminders:auctions';
    protected $description = 'Send email reminders 2 hours before auction starts to subscribed users';

    public function handle()
    {
        $now = Carbon::now();
        $twoHoursLater = $now->copy()->addHours(2);
        $twoHoursFiftyLater = $now->copy()->addHours(2)->addMinutes(50);

        $auctions = Auctions::whereDate('auction_date', $now->toDateString())
            ->whereBetween('auction_date', [$twoHoursLater, $twoHoursFiftyLater])
            ->get();

        if ($auctions->isEmpty()) {
            $this->info("No auctions starting in the 2 to 2:50 hours window today.");
            return 0;
        }

        foreach ($auctions as $auction) {
            $this->info("Processing Auction ID: {$auction->id} | Name: {$auction->name} | Starts at: {$auction->auction_date}");

            $alerts = PlatefromAlert::where('auction_id', $auction->id)
                        ->where('is_sent', 0) 
                        ->get();

            foreach ($alerts as $alert) {

                $setting = UserNotificationSetting::where('user_id', $alert->user_id)
                    ->where('type', 'calendar_reminder')
                    ->where('email', 1)
                    ->where('send_preference', 'anytime')
                    ->first();

                if ($setting) {
                    $user = $setting->user;

                
                    Mail::to($user->personalEmail)->send(new AuctionReminderMail($auction));
                  

            
                    $title = "Auction Reminder: {$auction->name}";
                    $message = "Your auction will start at {$auction->auction_date}";
                    $link = "auction-finder?platform=".$auction->platform_id ;
                    $image= "https://www.shutterstock.com/image-vector/car-auction-vector-outline-icon-600nw-2255563925.jpg";
                    event(new NotificationEvent($user, $title, $message,$link,$image));

                    $alert->is_sent = 1;
                    $alert->save();
                }
            }
        }

        return 0;
    }
}
