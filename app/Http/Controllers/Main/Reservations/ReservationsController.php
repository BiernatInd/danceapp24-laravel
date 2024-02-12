<?php

namespace App\Http\Controllers\Main\Reservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservations\ReservationsList;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReservationsController extends Controller
{

    public function getReservationsDate($date)
    {
        $formattedDate = str_replace('-', '.', $date);

        $reservations = ReservationsList::where('reservation_start_date', $formattedDate)->get();
        return response()->json($reservations);
    }
    
    public function getReservationsFilterSchoolName($date, $schoolName = null)
    {
        $formattedDate = str_replace('-', '.', $date);

        $query = ReservationsList::where('reservation_start_date', $formattedDate);

        if ($schoolName && $schoolName !== 'all') {
            $query->where('school_name', $schoolName);
        }
        $reservations = $query->get();

        return response()->json($reservations);
    }

    public function getReservationsFilterInstructor($date, $instructor = null)
    {
        $formattedDate = str_replace('-', '.', $date);

        $query = ReservationsList::where('reservation_start_date', $formattedDate);

        if ($instructor && $instructor !== 'all') {
            $query->where('instructor', $instructor);
        }
        $reservations = $query->get();

        return response()->json($reservations);
    }

    public function getReservationsFilterClassType($date, $classType = null)
    {
        $formattedDate = str_replace('-', '.', $date);

        $query = ReservationsList::where('reservation_start_date', $formattedDate);

        if ($classType && $classType !== 'all') {
            $query->where('class_type', $classType);
        }
        $reservations = $query->get();

        return response()->json($reservations);
    }
    
}