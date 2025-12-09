<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    public function handleStripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET'); // Store your webhook secret in .env

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Inval id payload
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('Invalid signature', 400);
        }

        // Handle the event
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $stripe = new StripeClient(config('services.stripe.secret'));
            $session = $stripe->checkout->sessions->retrieve($session->id);

            if ($session->payment_status === 'paid') {
                // Payment is successful, update your database
                // You can get the relevant data from $session
                $userId = Auth::id(); // Get user ID.  You might need to adjust how you get this.
                $planId = $session->metadata['plan_id'] ?? null;  //  Get plan_id

                if ($userId && $planId) {

                    $payment = new Payment();
                    $payment->user_id = $userId;
                    $payment->plan_id = $planId;
                    $payment->payment_method = 'stripe';
                    $payment->transaction_id = $session->payment_intent;
                    $payment->amount = $session->amount_total / 100;
                    $payment->currency = $session->currency;
                    $payment->payment_status = 'Completed';
                    $payment->save();

                    $membership = Membership::where('user_id', $userId)->first();
                    $plan = MembershipPlan::findOrFail($planId);
                    if ($membership) {
                        //update
                        $membership->plan_id = $planId;
                        $membership->membership_start_date = now();
                        $membership->membership_expiry_date = now()->add($plan->duration_value, $plan->duration_unit);
                        $membership->membership_status = 'Active';
                        $membership->save();
                    } else {
                        //create
                        $membership = new Membership();
                        $membership->user_id = $userId;
                        $membership->plan_id = $planId;
                        $membership->membership_start_date = now();
                        $membership->membership_expiry_date = now()->add($plan->duration_value, $plan->duration_unit);
                        $membership->membership_status = 'Active';
                        $membership->save();
                    }
                }
            }
        }
        // Handle other event types as needed

        return response('Webhook Handled', 200);
    }
}
