<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PayPalController extends Controller
{
    public function createPayment()
    {
        $client = new \PayPalCheckoutSdk\Core\PayPalHttpClient(
            new \PayPalCheckoutSdk\Core\SandboxEnvironment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'))
        );

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "value" => "10",
                        "currency_code" => "USD"
                    ]
                ]
            ],
            "application_context" => [
                "cancel_url" => route('paypal.cancelPayment'),
                "return_url" => route('paypal.executePayment')
            ]
        ];

        try {
            $response = $client->execute($request);
            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    return redirect($link->href);
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function executePayment(Request $request)
    {
        $client = new \PayPalCheckoutSdk\Core\PayPalHttpClient(
            new \PayPalCheckoutSdk\Core\SandboxEnvironment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'))
        );

        $request = new OrdersCaptureRequest($request->query('token'));

        try {
            $response = $client->execute($request);
            return view('paypal.confirmation');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function cancelPayment()
    {
        return 'Payment cancelled.';
    }
}