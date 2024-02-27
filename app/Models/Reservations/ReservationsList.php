<?php

namespace App\Models\Reservations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationsList extends Model
{
    use HasFactory;

    protected $table = 'reservations_list';

    protected $fillable = [
        'school_name',
        'class_hours',
        'class_type',
        'class_name',
        'designation',
        'room_number',
        'places_for_women',
        'places_for_men',
        'instructor',
        'reservation_start_date',
        'reservation_end_date',
        'price',
        'slug',
    ];
}