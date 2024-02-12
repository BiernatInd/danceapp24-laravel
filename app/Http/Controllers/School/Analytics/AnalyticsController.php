<?php

namespace App\Http\Controllers\School\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\Orders;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function schoolGetMonthlyPurchases($schoolName, $month)
    {
        $monthNumber = $this->convertMonthNameToNumber($month);
    
        if ($monthNumber === null) {
            return response()->json(['error' => 'Invalid month name'], 400);
        }

        $orders = Orders::where('school_name', $schoolName)
                    ->whereMonth('created_at', $monthNumber)
                    ->get();
    
        return response()->json([
            'orders' => $orders,
        ]);
    }

    public function convertMonthNameToNumber($monthName)
    {
        $months = [
            'january' => 1,
            'february' => 2,
            'match' => 3,
            'april' => 4,
            'may' => 5,
            'june' => 6,
            'july' => 7,
            'august' => 8,
            'september' => 9,
            'october' => 10,
            'november' => 11,
            'december' => 12,
        ];
    
        return $months[strtolower($monthName)] ?? null;
    }
    
    public function schoolGetYearlyPurchases($schoolName)
    {
        $orders = Orders::where('school_name', $schoolName)
                    ->selectRaw('MONTH(created_at) as month, SUM(price) as total')
                    ->whereYear('created_at', date('Y'))
                    ->groupBy('month')
                    ->get();
    
        return response()->json([
            'orders' => $orders,
        ]);
    }
}
