<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersListTable extends Migration
{
    public function up()
    {
        Schema::create('orders_list', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('class_hours');
            $table->string('class_type');
            $table->string('designation');
            $table->string('room_number');
            $table->string('places_for_women');
            $table->string('places_for_men');
            $table->string('instructor');
            $table->date('reservation_start_date');
            $table->date('reservation_end_date');
            $table->string('price');
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('phone');
            $table->string('first_checkbox');
            $table->string('second_checkbox')->nullable();
            $table->string('third_checkbox')->nullable();
            $table->string('fourth_checkbox')->nullable();
            $table->string('status')->default('Payment unpaid');
            $table->string('order_number');
            $table->string('slug');
            $table->string('user_name')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders_list');
    }
}