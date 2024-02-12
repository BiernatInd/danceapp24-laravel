<?php

namespace App\Http\Controllers\Main\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DateController extends Controller
{
    public function index($year, $monthName)
    {
        Carbon::setLocale('pl');
    
        $dates = [];
        $requestedDate = Carbon::parse("$year-$monthName");
        $month = $requestedDate->month;
    
        $startDate = Carbon::create($year, $month, 1);
        $today = Carbon::today();
    
        if ($year == $today->year && $month == $today->month) {
            $startDate = $today->copy();
        }
    
        if ($startDate->lt($today->startOfMonth())) {
            return response()->json(['error' => 'Nie można wywołać dat z przeszłości.'], 400);
        }
    
        while ($startDate->month === $month) {
            array_push($dates, $startDate->format('j l'));
            $startDate->addDay();
        }
    
        $formattedMonth = ucfirst($requestedDate->format('F Y'));
    
        return response()->json([$formattedMonth => $dates]);
    }

}