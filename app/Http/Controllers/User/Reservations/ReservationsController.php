<?php

namespace App\Http\Controllers\User\Reservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\Orders;

class ReservationsController extends Controller
{
    public function userReservationsList($user_name)
    {
        $reservations = Orders::where('user_name', $user_name)
                                        ->get();

        return response()->json($reservations);
    }

    public function userReservationsContent($user_name, $order_number)
    {
        $reservations = Orders::where('user_name', $user_name)
                                        ->where('order_number', $order_number)
                                        ->get();

        return response()->json($reservations);
    }
}
