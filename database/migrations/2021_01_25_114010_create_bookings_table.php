<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('CheckoutRequestID')->nullable();
            $table->string('group');
            $table->string('seaters')->nullable();
            $table->string('amount');
            $table->string('fullname')->nullable();
            $table->string('id_no');
            $table->string('pick_up')->nullable();
            $table->string('mobile');
            $table->string('time')->nullable();
            $table->string('travel_date')->nullable();
            $table->string('ticket_no');
            $table->string('seat_no')->nullable();
            $table->string('departure');
            $table->string('destination');
            $table->string('is_paid')->default(0);
            $table->string('ticket_token')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('dispatched')->default(0);
            $table->string('suspended')->default(0);
            $table->string('online')->default(0);
            $table->string('fleet_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
