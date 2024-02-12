<?php

namespace App\Http\Controllers\Admin\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\Orders;

class AnalyticsController extends Controller
{
    public function adminGetMonthlyPurchases($month)
    {
        $monthNumber = $this->convertMonthNameToNumber($month);
    
        if ($monthNumber === null) {
            return response()->json(['error' => 'Invalid month name'], 400);
        }
    
        $orders = Orders::whereMonth('created_at', $monthNumber)->get();
    
    
        return response()->json([
            'orders' => $orders,
        ]);
    }

    public function convertMonthNameToNumber($monthName)
{
    $months = [
        'styczen' => 1,
        'luty' => 2,
        'marzec' => 3,
        'kwiecien' => 4,
        'maj' => 5,
        'czerwiec' => 6,
        'lipiec' => 7,
        'sierpien' => 8,
        'wrzesien' => 9,
        'pazdziernik' => 10,
        'listopad' => 11,
        'grudzien' => 12,
    ];

    return $months[strtolower($monthName)] ?? null;
}

    public function adminGetYearlyPurchases()
    {
    $orders = Orders::selectRaw('MONTH(created_at) as month, SUM(price) as total')
    ->whereYear('created_at', date('Y'))
    ->groupBy('month')
    ->get();

        return response()->json([
            'orders' => $orders,
        ]);
    }
}
