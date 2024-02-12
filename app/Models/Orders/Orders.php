<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders_list';

    protected $fillable = [
        'school_name',
        'class_hours',
        'class_type',
        'designation',
        'room_number',
        'places_for_women',
        'places_for_men',
        'instructor',
        'reservation_start_date',
        'reservation_end_date',
        'price',
        'name',
        'surname',
        'email',
        'phone',
        'first_checkbox',
        'second_checkbox',
        'third_checkbox',
        'fourth_checkbox',
        'status',
        'order_number',
        'slug',
        'user_name',
    ];
}