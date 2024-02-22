<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data['usersCount'] = User::count();
        $data['ordersCount'] = Order::where('status', Order::STATUS['paid'])->count();
        $data['revenue'] = Order::where('status', Order::STATUS['paid'])->sum('total_amount');

        // Fetch historical data for orders
        $ordersData = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('status', Order::STATUS['paid'])
            ->groupBy('date')
            ->get();

        // Prepare data for chart
        $dates = $ordersData->pluck('date');
        $orderCounts = $ordersData->pluck('count');

        return view('index', compact('data', 'dates', 'orderCounts'));
    }
}
