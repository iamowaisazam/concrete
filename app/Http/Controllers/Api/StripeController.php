<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionPlatform;
use App\Models\Auctions;
use App\Models\RecentView;
use App\Models\Notification;
use App\Models\Membership;
use App\Models\MembershipPayment;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Interest;
use App\Models\AuctionCenter;
use App\Models\UserNotificationAlert;
use App\Models\UserVehicleAlert;
use App\Models\Vehicle;
use App\Services\PlanService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{


    public function createPaymentIntent(Request $request)
    {

              
            $user = $request->user();
     
            $plan = Plan::find($request->plan_id);
            if(!$plan){
                return response()->json([
                    'message' => 'Plan Not Found'
                ], 400);
            }


            // dd($plan->price);

            if ((float)$plan->price === 0.0) {

                    $data = [
                        'transactionId' => uniqid(), 
                        'first_name'   => $request->first_name,
                        'last_name'    => $request->last_name,
                        'phone'        => $request->phone,
                        'country'      => $request->country,
                        'state'        => $request->state,
                        'city'         => $request->city,
                        'zip_code'     => $request->zip_code,
                        'address'      => $request->address,
                    ];

                    $membership = PlanService::createMemberShip($plan,$user);
                    $payment = PlanService::createPayment($membership,$data);

                    return response()->json([
                        'message'       => "Payment Successfully Created",
                        'data'  => $payment
                    ]);

            }else{


        
                Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                
                try {
                    $amount = (float) $plan->price;
                    $paymentIntent = PaymentIntent::create([
                        'amount'   => $amount * 100,     // £50 → 5000
                        'currency' => 'gbp',
                        'payment_method' => $request->payment_method_id,
                        'confirm' => true,
                        'automatic_payment_methods' => [
                            'enabled' => true,
                            'allow_redirects' => 'never'   // THIS LINE KILLS THE ERROR FOREVER
                        ],
                    ]);

                    $transactionId = $paymentIntent->latest_charge;

                    $data = [
                        'transactionId' => $transactionId, 
                        'first_name'   => $request->first_name,
                        'last_name'    => $request->last_name,
                        'phone'        => $request->phone,
                        'country'      => $request->country,
                        'state'        => $request->state,
                        'city'         => $request->city,
                        'zip_code'     => $request->zip_code,
                        'address'      => $request->address,
                    ];

                    $membership = PlanService::createMemberShip($plan,$user);
                    $payment = PlanService::createPayment($membership,$data);

                    return response()->json([
                        'success'       => true,
                        'clientSecret'  => $paymentIntent->client_secret,  // Send this to frontend
                    ]);

                } catch (\Exception $e) {
                    return response()->json([
                        'message' => $e->getMessage()
                    ], 400);
                }


        }
        
        


    }


       private function planCreate($transactionId,Plan $plan, $request)
    {

  


        $user = Auth::user();
        $startDate = now();
        $expiryDate = now()->addMonths($plan->duration_value);

        $membership = Membership::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'membership_start_date' => $startDate,
            'membership_expiry_date' => $expiryDate,
            'membership_status' => 'Pending',
            'membership_type' => 'monthly',
        ]);

        MembershipPayment::create([
            'membership_id' => $membership->id,
            'payment_date' => now(),
            'payment_method' => 'stripe',
            'transaction_id' => $transactionId,
            'charge_id' => $transactionId,
            'payer_id' => $transactionId,
            'amount' => $plan->price,
            'currency' => 'GBP',
            'payment_status' => 'Completed',
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
        ]);

        $membership->update(['membership_status' => 'Active']);

    }



}