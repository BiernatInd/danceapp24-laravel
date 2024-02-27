<?php

namespace App\Http\Controllers\Main\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\Orders;
use App\Models\Reservations\ReservationsList;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    public function sendOrders(Request $request) {
        $validatedData = $request->validate([
            'school_name' => 'required|string',
            'class_hours' => 'required|string',
            'class_type' => 'required|string',
            'class_name' => 'required|string',
            'designation' => 'required|string',
            'room_number' => 'required|string',
            'places_for_women' => 'required|string',
            'places_for_men' => 'required|string',
            'instructor' => 'required|string',
            'reservation_start_date' => 'required|string',
            'reservation_end_date' => 'required|string',
            'price' => 'required|string',
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'first_checkbox' => 'required|string',
            'second_checkbox' => 'nullable|string',
            'third_checkbox' => 'nullable|string',
            'fourth_checkbox' => 'nullable|string',
            'slug' => 'required|string',
            'user_name' => 'nullable|string',

        ]);
        
        $validatedData['order_number'] = $this->generate_order_number();

        if (($request->input('first_checkbox') === 'Pani' && empty($validatedData['places_for_women'])) ||
            ($request->input('first_checkbox') === 'Pan' && empty($validatedData['places_for_men']))) {
            return response()->json(['error' => 'Please specify the number of places for men or women.'], 400);
        }
        
        $order = Orders::create($validatedData);

       if ($request->input('first_checkbox') === 'Pani') {
        $reservation = ReservationsList::where('school_name', $request->input('school_name'))
                                        ->where('class_hours', $request->input('class_hours'))
                                        ->first();
        
        if ($reservation && is_numeric($reservation->places_for_women)) {
            $placesForWomen = max((int)$reservation->places_for_women - 1, 0);
            $reservation->places_for_women = (string)$placesForWomen;
            $reservation->save();
        }
    }

    if ($request->input('first_checkbox') === 'Pan') {
        $reservation = ReservationsList::where('school_name', $request->input('school_name'))
                                        ->where('class_hours', $request->input('class_hours'))
                                        ->first();
        
        if ($reservation && is_numeric($reservation->places_for_men)) {
            $placesForMen = max((int)$reservation->places_for_men - 1, 0);
            $reservation->places_for_men = (string)$placesForMen;
            $reservation->save();
        }
    }


    $orderData = $order->toArray();
    Mail::to($order->email)->send(new OrderConfirmationMail($orderData));

        return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
    }

    public function generate_order_number($length = 8) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $characters[mt_rand(0, $max)];
        }
        return $str;
    }

    public function orderStatus($order_number)
    {
        $order = Orders::where('order_number', $order_number)
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }
    
}
