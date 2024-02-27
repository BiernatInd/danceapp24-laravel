<?php

namespace App\Http\Controllers\School\Reservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Orders\Orders;
use App\Models\Reservations\ReservationsList;

class ReservationsController extends Controller
{
    public function schoolReservationsListData($school_name, $date)
    {
        $reservations = ReservationsList::where('school_name', $school_name)
                                        ->where('reservation_start_date', $date)
                                        ->get();

        return response()->json($reservations);
    }

    public function schoolReservationsList($school_name, $date, $slug)
    {
        $reservations = Orders::where('school_name', $school_name)
                                        ->where('reservation_start_date', $date)
                                        ->where('slug', $slug)
                                        ->get();

        return response()->json($reservations);
    }

    public function schoolDeleteOrders($id)
    {
        $orders = Orders::findOrFail($id);
        $orders->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }

    public function schoolOrderListContent($school_name, $id)
    {
        $order = Orders::where('school_name', $school_name)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    public function updateOrderStatus($school_name, $id, Request $request)
    {
        $order = Orders::where('school_name', $school_name)
                       ->where('id', $id)
                       ->firstOrFail();

        $order->status = $request->new_order_status;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully']);
    }

    public function schoolReservationsListSchoolName($school_name)
    {
        $reservations = ReservationsList::where('school_name', $school_name)
                                        ->get();

        return response()->json($reservations);
    }

    public function schoolReservationsListSlug($school_name, $slug)
    {
        $reservations = ReservationsList::where('school_name', $slug)
                                        ->where('slug', $slug)
                                        ->get();

        return response()->json($reservations);
    }

    public function schoolReservationsDelete($id)
    {
        $reservations = ReservationsList::findOrFail($id);
        $reservations->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }

    public function schoolReservationsAdd(Request $request)
    {
    DB::beginTransaction();

    try {
        $reservation = new ReservationsList();
        $reservation->school_name = $request->school_name;
        $reservation->class_type = $request->class_type;

        $lastRecord = ReservationsList::orderBy('id', 'desc')->lockForUpdate()->first();
        $slug = $lastRecord ? intval($lastRecord->slug) + 1 : 1;

        $reservation->slug = strval($slug);
        $reservation->save();

        DB::commit();

        return response()->json(['message' => 'Reservation added successfully', 'slug' => $reservation->slug]);
    } catch (\Exception $e) {
        DB::rollback();

        return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
    }
    }

    public function schoolReservationsAddPlaces(Request $request)
    {
        $reservation = ReservationsList::where('school_name', $request->school_name)
                                        ->where('slug', $request->slug)
                                        ->first();
    
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
    
        $reservation->places_for_women = $request->places_for_women;
        $reservation->places_for_men = $request->places_for_men;
        $reservation->save();
    
        return response()->json(['message' => 'Reservation updated successfully']);
    }

    public function schoolReservationsAddClassName(Request $request)
    {
        $reservation = ReservationsList::where('school_name', $request->school_name)
                                        ->where('slug', $request->slug)
                                        ->first();
    
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
    
        $reservation->class_name= $request->class_name;
        $reservation->save();
    
        return response()->json(['message' => 'Reservation updated successfully']);
    }

    public function schoolReservationsAddTime(Request $request)
    {
        $reservation = ReservationsList::where('school_name', $request->school_name)
                                        ->where('slug', $request->slug)
                                        ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation->class_hours = $request->class_hours;
        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully']);
    }

    public function schoolReservationsAddStartDate(Request $request)
    {
        $reservation = ReservationsList::where('school_name', $request->school_name)
                                        ->where('slug', $request->slug)
                                        ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation->reservation_start_date = $request->reservation_start_date;
        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully']);
    }

    public function schoolReservationsAddEndDate(Request $request)
    {
        $reservation = ReservationsList::where('school_name', $request->school_name)
                                        ->where('slug', $request->slug)
                                        ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation->reservation_end_date = $request->reservation_end_date;
        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully']);
    }

    public function schoolReservationsAddDesignation(Request $request)
    {
        $reservation = ReservationsList::where('school_name', $request->school_name)
                                        ->where('slug', $request->slug)
                                        ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation->designation = $request->designation;
        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully']);
    }
    

    public function schoolReservationsAddRoom(Request $request)
    {
        $reservation = ReservationsList::where('school_name', $request->school_name)
                                        ->where('slug', $request->slug)
                                        ->first();
    
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
    
        $reservation->room_number = $request->room_number;
        $reservation->save();
    
        return response()->json(['message' => 'Reservation updated successfully']);
    }
    
    public function schoolReservationsAddInstructor(Request $request)
    {
        $reservation = ReservationsList::where('school_name', $request->school_name)
                                        ->where('slug', $request->slug)
                                        ->first();
    
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
    
        $reservation->instructor = $request->instructor;
        $reservation->save();
    
        return response()->json(['message' => 'Reservation updated successfully']);
    }
    
    public function schoolReservationsAddPrice(Request $request)
    {
        $reservation = ReservationsList::where('school_name', $request->school_name)
                                        ->where('slug', $request->slug)
                                        ->first();
    
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
    
        $reservation->price = $request->price;
        $reservation->save();
    
        return response()->json(['message' => 'Reservation updated successfully']);
    }

    public function schoolReservationsDownloadContent($school_name, $slug)
    {
        $reservations = ReservationsList::where('school_name', $school_name)
                                        ->where('slug', $slug)
                                        ->get();

        return response()->json($reservations);
    }

    public function schoolReservationsEditClassType(Request $request, $school_name, $slug)
    {
        $reservation = ReservationsList::where('school_name', $school_name)
                                       ->where('slug', $slug)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($request->has('class_type')) {
            $reservation->class_type = $request->class_type;
        }

        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully', 'updated_reservation' => $reservation]);
    }

    public function schoolReservationsEditClassName(Request $request, $school_name, $slug)
    {
        $reservation = ReservationsList::where('school_name', $school_name)
                                       ->where('slug', $slug)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($request->has('class_name')) {
            $reservation->class_name = $request->class_name;
        }

        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully', 'updated_reservation' => $reservation]);
    }

    public function schoolReservationsEditPlaces(Request $request, $school_name, $slug)
    {
        $reservation = ReservationsList::where('school_name', $school_name)
                                       ->where('slug', $slug)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($request->has('places_for_women')) {
            $reservation->places_for_women = $request->places_for_women;
        }

        
        if ($request->has('places_for_men')) {
            $reservation->places_for_men = $request->places_for_men;
        }

        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully', 'updated_reservation' => $reservation]);
    }

    public function schoolReservationsEditStartDate(Request $request, $school_name, $slug)
    {
        $reservation = ReservationsList::where('school_name', $school_name)
                                       ->where('slug', $slug)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($request->has('reservation_start_date')) {
            $reservation->reservation_start_date = $request->reservation_start_date;
        }

        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully', 'updated_reservation' => $reservation]);
    }

    public function schoolReservationsEditEndDate(Request $request, $school_name, $slug)
    {
        $reservation = ReservationsList::where('school_name', $school_name)
                                       ->where('slug', $slug)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($request->has('reservation_end_date')) {
            $reservation->reservation_end_date = $request->reservation_end_date;
        }

        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully', 'updated_reservation' => $reservation]);
    }

    public function schoolReservationsEditTime(Request $request, $school_name, $slug)
    {
        $reservation = ReservationsList::where('school_name', $school_name)
                                       ->where('slug', $slug)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($request->has('class_hours')) {
            $reservation->class_hours = $request->class_hours;
        }

        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully', 'updated_reservation' => $reservation]);
    }

    public function schoolReservationsEditDesignation(Request $request, $school_name, $slug)
    {
        $reservation = ReservationsList::where('school_name', $school_name)
                                       ->where('slug', $slug)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($request->has('designation')) {
            $reservation->designation = $request->designation;
        }

        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully', 'updated_reservation' => $reservation]);
    }
    
    public function schoolReservationsEditRoom(Request $request, $school_name, $slug)
    {
        $reservation = ReservationsList::where('school_name', $school_name)
                                       ->where('slug', $slug)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($request->has('room_number')) {
            $reservation->room_number = $request->room_number;
        }

        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully', 'updated_reservation' => $reservation]);
    }

    public function schoolReservationsEditInstructor(Request $request, $school_name, $slug)
    {
        $reservation = ReservationsList::where('school_name', $school_name)
                                       ->where('slug', $slug)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($request->has('instructor')) {
            $reservation->instructor = $request->instructor;
        }

        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully', 'updated_reservation' => $reservation]);
    }

    public function schoolReservationsEditPrice(Request $request, $school_name, $slug)
    {
        $reservation = ReservationsList::where('school_name', $school_name)
                                       ->where('slug', $slug)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($request->has('price')) {
            $reservation->price = $request->price;
        }

        $reservation->save();

        return response()->json(['message' => 'Reservation updated successfully', 'updated_reservation' => $reservation]);
    }
}
