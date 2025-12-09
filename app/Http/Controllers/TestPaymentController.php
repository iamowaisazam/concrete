<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class TestPaymentController extends Controller
{
    public function showPaymentForm()
    {
        $amount = 15.00; // Amount in pounds
        return view('test_payment_form', compact('amount'));
    }

    public function processPayment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('payment.success'),
                "cancel_url" => route('payment.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "GBP",
                        "value" => sprintf("%.2f", $request->amount),
                    ],
                ],
            ],
        ]);

        if (isset($order['id']) && $order['id'] != null) {
            foreach ($order['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('payment.cancels')->with('error', 'Something went wrong with PayPal.');
        }
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()->route('payment.successful')->with('success', 'Payment successful!');
        } else {
            return redirect()->route('payment.cancel')->with('error', 'Payment failed.');
        }
    }

    public function paymentCancel()
    {
        return redirect()->route('payment.failed')->with('error', 'Payment was cancelled.');
    }

    public function paymentSuccessful()
    {
        return view('payment_successful');
    }

    public function paymentFailed()
    {
        return view('payment_failed');
    }
}