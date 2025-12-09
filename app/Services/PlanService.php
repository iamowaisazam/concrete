<?php

namespace App\Services;

use App\Models\Auctions;
use App\Models\Interest;
use App\Models\Membership;
use App\Models\MembershipPayment;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PlanService 
{
    
        static public function createMemberShip(Plan $plan,User $user)
    {

        $startDate = now();
        $expiryDate = now()->addMonths($plan->duration_value);

        return Membership::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'membership_start_date' => $startDate,
                'membership_expiry_date' => $expiryDate,
                'membership_status' => 'Pending',
                'membership_type' => 'monthly',
        ]);

    }


    static public function createPayment(Membership $membership,$data)
    {

           $MembershipPayment = MembershipPayment::create([
                'membership_id' => $membership->id,
                'payment_date' => now(),
                'payment_method' => 'stripe',
                'transaction_id' => $data['transactionId'],
                'charge_id' => $data['transactionId'],
                'payer_id' => $data['transactionId'],
                'amount' => $membership->plan->price,
                'currency' => 'GBP',
                'payment_status' => 'Completed',
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'zip_code' => $data['zip_code'],
                'address' => $data['address'],
            ]);

            $membership->update(['membership_status' => 'Active']);

            return $MembershipPayment;
        
    }


   static public function getAuctionIdbyDate($date)
    {
    
         return Auctions::whereDate('auction_date', '=', $date)
              ->pluck('id');
    }

    static public function getPlateformNamesByAuctionId($auctionIds)
    {

        return Auctions::join('auction_platform', 'auction_platform.id', '=', 'auctions.platform_id')
          ->whereIn('auctions.id', $auctionIds)
          ->distinct()
          ->pluck('auction_platform.name')
          ->filter()
          ->values();

    }

       static public function getCenterNamesByPlateformName($auctionIds)
    {

        return Vehicle::join('auction_center', 'auction_center.id', '=', 'vehicles.center_id')
        ->whereIn('vehicles.auction_id', $auctionIds)
        ->distinct()
        ->pluck('auction_center.name')
        ->filter()
        ->values();
    
    }

}
