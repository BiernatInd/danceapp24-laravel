<?php

namespace App\Http\Controllers\Admin\Reservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservations\ReservationsList;
use App\Models\Orders\Orders;
use Illuminate\Support\Facades\Hash;

class ReservationsController extends Controller
{
    public function adminSchoolList()
    {
        $usersWithSchoolRole = User::where('role', 'school')->get();

        return response()->json($usersWithSchoolRole);
    }

    public function adminReservationsList($school_name,)
    {
        $reservations = ReservationsList::where('school_name', $school_name)
                                        ->get();

        return response()->json($reservations);
    }

    public function adminSchoolReservationsContent($school_name, $slug)
    {
        $reservations = ReservationsList::where('school_name', $school_name)
                                        ->where('slug', $slug)
                                        ->get();

        return response()->json($reservations);
    }

    public function adminSchoolReservationsUsers($school_name, $slug)
    {
        $reservations = Orders::where('school_name', $school_name)
                                        ->where('slug', $slug)
                                        ->get();

        return response()->json($reservations);
    }

    public function adminSchoolReservationsUsersContent($school_name, $slug, $order_number)
    {
        $reservations = Orders::where('school_name', $school_name)
                                        ->where('slug', $slug)
                                        ->where('order_number', $order_number)
                                        ->get();

        return response()->json($reservations);
    }

    public function adminSchoolReservationsUsersContentDelete($id)
    {
        $reservation = Orders::where('id', $id)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }

    public function adminSchoolReservationsListDelete($school_name, $id)
    {
        $reservation = ReservationsList::where('school_name', $school_name)
                                       ->where('id', $id)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }

    public function adminSchoolReservationsDelete($id)
    {
        $reservation = User::where('id', $id)
                                       ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }

    public function adminSchoolAdd(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User([
            'user_name' => $request->input('user_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'school',
        ]);

        $user->save();

        return response()->json(['message' => 'Użytkownik zarejestrowany pomyślnie'], 201);
    }
    
    public function adminOrdersList()
    {
        $categories = Orders::all(); 

        return response()->json($categories); 
    }

    public function adminSchoolEditContent($userName, $id)
    {
        $user = User::where('user_name', $userName)
                    ->where('id', $id)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function adminSchoolEditRole(Request $request, $userName, $id)
    {
        $user = User::where('user_name', $userName)
                    ->where('id', $id)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->role = $request->input('role');
        $user->save();

        return response()->json(['message' => 'Rola została zaktualizowana pomyślnie']);
    }
    
    public function adminSchoolEditUpdateRole(Request $request, $userName, $id)
    {
        $user = User::where('user_name', $userName)
                    ->where('id', $id)
                    ->first();
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $newUpdateRole = $request->input('update_role');
    
    
        $user->update_role = $newUpdateRole;
    
        $user->created_at = now();
    
        $user->save();
    
        return response()->json(['message' => 'Rola i data utworzenia zostały zaktualizowane pomyślnie']);
    }
    
}
