<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Membership;
use App\Models\MembershipPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function index($id = null)
    {
        $plans = Plan::all();
        $selectedPlan = $id ? Plan::find($id) : null;

        return view('user.checkout.index', compact('plans', 'selectedPlan'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'plan_id' => 'required|exists:membership_plans,id',
            'payment_method' => 'required|in:stripe,paypal',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $user = Auth::user();

        $startDate = now();
        $expiryDate = now()->addMonths($plan->duration_value);


        try {

            $membership = Membership::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'membership_start_date' => $startDate,
                'membership_expiry_date' => $expiryDate,
                'membership_status' => 'Pending',
            ]);

            if ($request->payment_method === 'stripe') {
                Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                $token = $request->input('stripeToken');
                if (!$token) {
                    return back()->with('error', 'Stripe token missing. Please try again.');
                }

                try {
                    $charge = Charge::create([
                        'amount' => $plan->price * 100,
                        'currency' => 'gbp',
                        'description' => 'Membership Plan: ' . $plan->plan_name,
                        'source' => $token,
                        'receipt_email' => $user->email,
                    ]);

                    MembershipPayment::create([
                        'user_id' => $user->id,
                        'membership_id' => $membership->id,
                        'plan_id' => $plan->id,
                        'payment_date' => now(),
                        'payment_method' => 'stripe',
                        'transaction_id' => $charge->id,
                        'charge_id' => $charge->id,
                        'amount' => $plan->price,
                        'currency' => 'GBP',
                        'payment_status' => 'Completed',
                    ]);

                    $membership->update(['membership_status' => 'Active']);

                    return redirect()->route('dashboard')->with('success', 'Payment successful.');
                } catch (\Exception $e) {
                    Log::error('Stripe payment failed: ' . $e->getMessage());
                    return back()->with('error', 'Payment failed: ' . $e->getMessage());
                }

            } elseif ($request->payment_method === 'paypal') {
                return redirect()->route('paypal.checkout', ['plan' => $plan->id]);
            }

            return back()->with('error', 'Invalid payment method.');
        } catch (\Exception $e) {
            Log::error('Checkout process failed: ' . $e->getMessage());
            return back()->with('error', 'An error occurred during checkout. Please try again.');
        }
    }
}
