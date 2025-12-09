<?php

namespace App\Services;

use App\Models\Auctions;
use App\Models\Interest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuctionService 
{

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
