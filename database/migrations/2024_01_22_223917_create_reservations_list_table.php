<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsListTable extends Migration
{
    public function up()
    {
        Schema::create('reservations_list', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('class_hours')->nullable();
            $table->string('class_type')->nullable();
            $table->string('designation')->nullable();
            $table->string('room_number')->nullable();
            $table->string('places_for_women')->nullable();
            $table->string('places_for_men')->nullable();
            $table->string('instructor')->nullable();
            $table->date('reservation_start_date')->nullable();
            $table->date('reservation_end_date')->nullable();
            $table->string('price')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations_list');
    }
}