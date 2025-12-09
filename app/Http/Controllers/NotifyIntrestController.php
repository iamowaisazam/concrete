<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\UserNotificationSetting;
use App\Models\Interest;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\NotificationEvent;
use App\Mail\InterestAlertMail;
use App\Mail\DailyVehicleSummary;

class NotifyIntrestController extends Controller
{
    public function sendInterestNotify(Request $request, $token = null)
    {
        $secret = env('CRON_SECRET');

        $isCli = php_sapi_name() === 'cli' || defined('STDIN');
        $isLocal = in_array($request->ip(), ['127.0.0.1', '::1']);
        $tokenMatches = $token && hash_equals($secret, $token);
        $headerToken = $request->header('X-CRON-TOKEN');
        if (!$tokenMatches && $headerToken) {
            $tokenMatches = hash_equals($secret, $headerToken);
        }

        if (! ($isCli || $isLocal || $tokenMatches)) {
            return response()->json(['message' => 'Forbidden. Invalid cron token or origin.'], 403);
        }

        $from = Carbon::now()->subDay();
        $to   = Carbon::now(); 
        $vehiclesQuery = Vehicle::whereBetween('created_at', [$from, $to]);

        $vehiclesCollection = $vehiclesQuery->get();

        $vehicles = $vehiclesCollection->map(function ($v) {
            return [
                'id' => $v->id,
                'title' => $v->title,
                'make_id' => $v->make_id,
                'model_id' => $v->model_id,
                'variant_id' => $v->variant_id,
                'images' => $v->images,
                'year' => $v->year,
            ];
        })->toArray();

        // Email notifications
        // $this->sendInterestAlerts($vehicles);

        // Browser + DB notifications
        $this->sendInterestBrowserNotifications($vehicles);

        return response()->json([
            'message' => 'Interest notifications processed.',
            'vehicles_count' => count($vehicles)
        ], 200);
    }

public function sendInterestAlerts($vehicles)
{
    $users = UserNotificationSetting::where('type', 'interest_alerts')
        ->where('email', 1)
        ->where('send_preference', 'anytime')
        ->with('user')
        ->get();

    foreach ($users as $userSetting) {
        $user = $userSetting->user;
        $interests = Interest::where('user_id', $user->id)->get();

        $interestSummary = [];

        foreach ($interests as $interest) {
            $count = 0;
            foreach ($vehicles as $vehicle) {
                $match = true;

                if ($interest->make_id && $interest->make_id != $vehicle['make_id']) $match = false;
                if ($interest->model_id && $interest->model_id != $vehicle['model_id']) $match = false;
                if ($interest->variant_id && $interest->variant_id != $vehicle['variant_id']) $match = false;

                if ($match) {
                    $count++;
                }
            }

            if ($count > 0) {
                $interestSummary[] = [
                    'interest' => $interest->title ?? 'Unnamed Interest',
                    'count'    => $count,
                ];
            }
        }

        if (!empty($interestSummary)) {
            $data = [
                'user_name'  => $user->firstName ?? $user->name,
                'user_email' => $user->personalEmail ?? $user->email,
                'summary'    => $interestSummary,
            ];

            Mail::to($data['user_email'])->send(new InterestAlertMail($data));
        }
    }
}

    /**
     * Browser (Pusher) + DB Notification
     */
public function sendInterestBrowserNotifications($vehicles)
{
    $users = UserNotificationSetting::where('type', 'interest_alerts')
        ->where('browser', 1)
        ->where('send_preference', 'anytime')
        ->with('user')
        ->get();

    foreach ($users as $userSetting) {
        $user = $userSetting->user;
        $interests = Interest::where('user_id', $user->id)->get();

        $matchedVehicles = []; 

        foreach ($interests as $interest) {
            foreach ($vehicles as $vehicle) {
                $match = true;

                if ($interest->make_id && $interest->make_id != $vehicle['make_id']) $match = false;
                if ($interest->model_id && $interest->model_id != $vehicle['model_id']) $match = false;
                if ($interest->variant_id && $interest->variant_id != $vehicle['variant_id']) $match = false;

                if ($match) {
                    $matchedVehicles[] = $vehicle;
                }
            }
        }


        if (!empty($matchedVehicles)) {
            $count = count($matchedVehicles);
            $firstVehicle = $matchedVehicles[0];
            $firstVehicle = $matchedVehicles[0];
            $imagesArray = explode(',', $firstVehicle['images']);
            $firstImage = trim($imagesArray[0]);
            $link = 'auctionscheduler';


            event(new NotificationEvent(
                $user,
                "AutoBoli Found $count Vehicles!",
                "We found $count vehicles matching your interests. For example: '{$firstVehicle['title']}' ({$firstVehicle['year']}).",
                $link,
                $firstImage
            ));
        }
    }
}




public function sendDailySummary()
{
    $today = Carbon::today();

    // ✅ Get users who should receive auction digest
    $users = UserNotificationSetting::where('type', 'auction_digest')
        ->where('email', 1)
        ->where('send_preference', 'anytime')
        ->with('user')
        ->get();


    $totalNew    = Vehicle::whereDate('created_at', $today)->count();
    $totalSold   = Vehicle::whereDate('updated_at', $today)
                        ->where('bidding_status', 'sold')
                        ->count();
    $totalUnsold = Vehicle::whereDate('updated_at', $today)
                        ->where('bidding_status', 'Provisional')
                        ->count();


    $summary = [
        'date'         => $today->toFormattedDateString(),
        'total_new'    => $totalNew,
        'total_sold'   => $totalSold,
        'total_unsold' => $totalUnsold,
    ];


    foreach ($users as $setting) {
        if ($setting->user && $setting->user->personalEmail) {
            Mail::to($setting->user->personalEmail)->send(new DailyVehicleSummary($summary));
        }
    }

    return response()->json([
        'status'  => 'success',
        'message' => "Daily summary sent successfully to " . $users->count() . " users",
        'data'    => $summary
    ]);
}

}
