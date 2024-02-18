<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function checkout(Request $request)
    {
        $shipping_address = $request->shipping_address;
        $products = $request->products;
        $user = auth()->user();
        $lineItems = [];

        foreach ($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => env('CASHIER_CURRENCY'),
                    'unit_amount' => $product['amount'] * 100,
                    'product_data' => [
                        'name' => $product['name'],
                    ],
                ],
                'quantity' => $product['quantity'],
            ];
        }

        $checkoutSession = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'customer_email' => $user->email,
            'mode' => 'payment',
            'success_url' => route('checkout-success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout-cancel'),
        ]);
        $order = Order::create([
            'shipping_address' => $shipping_address,
            'user_id' => $user->id,
            'status' => Order::STATUS['unpaid'],
            'session_id' => $checkoutSession->id,
        ]);
        foreach ($products as $product) {
            OrderItems::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
            ]);
        }
        return $this->apiResponse(['payment_url' => $checkoutSession->url]);
    }

    public function checkoutSuccess(Request $request)
    {
        $sessionId = $request->query('session_id');
        $checkoutSession = \Stripe\Checkout\Session::retrieve($sessionId);

        if ($checkoutSession->payment_status == Order::STATUS['paid']) {
            $order = Order::where('session_id', $sessionId)->first();
            $order->update([
                'status' => Order::STATUS['paid'],
            ]);
            return redirect('https://smaster.live');
        }
    }
}
