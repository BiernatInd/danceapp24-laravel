<?php

namespace App\Http\Controllers\Plugin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservations\ReservationsList;

class PluginController extends Controller
{
    public function pluginReservationsList($date, $school_name)
    {
        $formattedDate = str_replace('-', '.', $date);

        $reservations = ReservationsList::where('reservation_date', $formattedDate)
                                         ->where('school_name', $school_name)
                                         ->get();
        return response()->json($reservations);
    }
}
