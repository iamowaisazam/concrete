<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Auction;
use App\Models\Auctions;
use App\Models\AuctionPlatform;
use App\Models\AuctionCenter;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class WebController extends Controller
{

    public function index()
    {


        return view('web.home');
    }

    public function features()
    {


        return view('web.features');
    }

    public function privacy()
    {


        return view('web.privacy');
    }

    public function terms()
    {


        return view('web.terms');
    }

    public function faq()
    {


        return view('web.faq');
    }

    public function cookiepolicy()
    {


        return view('web.cookiepolicy');
    }

    public function disclaimer()
    {


        return view('web.disclaimer');
    }

    public function about()
    {


        return view('web.about');
    }




    public function pricing()
    {
        return view('web.pricing');
    }

    public function privecy()
    {
        return view('web.privecy');
    }
    public function faqs()
    {
        return view('web.faqs');
    }
    public function newss()
    {
        return view('web.newss');
    }
    public function AutionShadule(Request $request)
    {
        if ($request->ajax()) {

            $query = Auctions::query()
                ->leftJoin('auction_platform', 'auctions.platform_id', '=', 'auction_platform.id')
                ->leftJoin('vehicles', 'auctions.id', '=', 'vehicles.auction_id')
                ->leftJoin('auction_center', 'vehicles.center_id', '=', 'auction_center.id')
                ->select(
                    'auctions.id',
                    'auction_platform.name as platform',
                    DB::raw('GROUP_CONCAT(DISTINCT auction_center.name ORDER BY auction_center.name SEPARATOR ", ") as center'),
                    DB::raw('COUNT(vehicles.id) as total_vehicles'),
                    'auctions.auction_date as time',
                    'auctions.status'
                )
                ->groupBy('auctions.id', 'auction_platform.name', 'auctions.auction_date', 'auctions.status')
                ->orderBy('auctions.auction_date', 'desc');

            if ($request->platform_id) {
                $query->where('auction_platform.id', $request->platform_id);
            }

            if ($request->center_id) {
                $query->where('vehicles.center_id', $request->center_id);
            }

            if ($request->status && $request->status !== 'all') {
                $query->where('auctions.status', 'In Progress');
            }
            if ($request->date) {
                $query->whereDate('auctions.auction_date', $request->date);
            }

            $auctions = $query->get();

            $response = [];
            foreach ($auctions as $auction) {
                $status = $auction->status ?? 'Planned';
                $statusClass = strtolower(str_replace(' ', '-', $status));
                $statusHtml = '<span class="status-badge status-' . $statusClass . '">' . $status . '</span>';

                $response[] = [
                    'platform' => $auction->platform ?? 'N/A',
                    'center' => $auction->center ?? 'N/A',
                    'total_vehicles' => $auction->total_vehicles,
                    'time' => date('d M Y, h:i A', strtotime($auction->time)),
                    'status' => $statusHtml,
                    'action' => '<a href="#" class="action-link">View/Alert/</a>',
                ];
            }

            return response()->json(['data' => $response]);
        }



        $today = Carbon::today();
        $next7Days = Carbon::today()->addDays(6);

        $dailyAuctions = Auctions::whereBetween('auction_date', [$today, $next7Days])
            ->select(
                DB::raw('DATE(auction_date) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('DATE(auction_date)'))
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->addDays($i);
            $formattedDate = $date->format('Y-m-d');

            $days[] = [
                'label' => $i === 0 ? 'Today' : $date->format('D'),
                'date' => $formattedDate,
                'display' => $date->format('d M'),
                'count' => $dailyAuctions[$formattedDate]->count ?? 0,
            ];
        }

        $platforms = AuctionPlatform::select('id', 'name')->get();
        $centers = AuctionCenter::select('id', 'name')->get();

        return view('web.AutionShadule', compact('platforms', 'centers', 'days'));
    }


    public function ExploreEvery()
    {
        return view('web.ExploreEvery');
    }

    public function compairaution()
    {
        return view('web.compairaution');
    }

    public function support()
    {
        return view('web.support');
    }
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'message' => 'required|string',
        ]);

        Mail::to(env('ADMIN_EMAIL'))->send(new ContactMail(
            $request->name,
            $request->email,
            $request->message,
            $request->phone,
            $request->country,
            $request->city,
            $request->postal_code,
            $request->address,
            $request->profession
        ));

        return response()->json(['status' => 'success', 'message' => 'Message sent successfully!']);
    }
}
