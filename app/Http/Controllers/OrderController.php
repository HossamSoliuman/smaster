<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use Hossam\Licht\Controllers\LichtBaseController;

class OrderController extends LichtBaseController
{

    public function index()
    {
        $orders = Order::all();
        $orders = OrderResource::collection($orders);
        return view('orders', compact('orders'));
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());
        return redirect()->route('orders.index');
    }

    public function show(Order $order)
    {
        return $this->successResponse(OrderResource::make($order));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return redirect()->route('orders.index');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index');
    }
}
